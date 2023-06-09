<?php

namespace HaiPG\LaravelCore\Aws;

use Aws\Exception\AwsException;
use Aws\Ses\SesClient;
use HaiPG\LaravelCore\Common\StringHelper;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SesMailTemplateService
{
    /** @var SesClient $ses */
    protected $ses = null;

    /** @var string $template */
    protected $template = null;

    /** @var mixed $result */
    protected $result = null;

    /** @var int $limit */
    protected $limit = 100;

    /** @var int $maxDestination */
    protected $maxDestination = 20;

    /** @var int $sendRate */
    protected $sendRate;

    /** @var array $configurationSet */
    protected $configurationSet = [];

    /** @var array $recipients */
    protected $recipients = [];

    /** @var array $dataDestinations */
    protected $dataDestinations = [];

    /**
     * SesMailTemplateService constructor.
     */
    public function __construct()
    {
        $hasCredentials = config('hpg.aws_credentials_flag');
        $config         = [
            'version' => 'latest',
            'region'  => config('services.ses.region')
        ];

        if ($hasCredentials) {
            $config['credentials'] = [
                'key'    => config('services.ses.key'),
                'secret' => config('services.ses.secret'),
            ];
        }

        $this->sendRate = config('services.ses.send_rate');
        $this->ses           = new SesClient($config);
    }

    /**
     * Set ConfigurationSet option
     *
     * @param string $config
     * @return $this
     */
    public function setConfigurationSet(string $config)
    {
        $this->configurationSet = $config;

        return $this;
    }

    /**
     * Set Template
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Set destinations
     *
     * @param array $dataDestinations
     * @return $this
     */
    public function setDataDestinations(array $dataDestinations)
    {
        $this->dataDestinations = $dataDestinations;

        return $this;
    }

    /**
     * Set limit for listing
     *
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Set Recipients
     *
     * @param array $recipients
     * @return $this
     */
    public function setRecipients(array $recipients)
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * Get list mail templates
     *
     * @return array|mixed
     */
    public function getListMailTemplate()
    {
        try {
            $this->result = $this->ses->listTemplates([
                'MaxItems' => $this->limit
            ])->toArray();

            return $this->result['TemplatesMetadata'];
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get detail a mail template
     *
     * @param string $name
     * @return array
     */
    public function getMailTemplate(string $name)
    {
        try {
            $this->result = $this->ses->getTemplate([
                'TemplateName' => $name
            ])->toArray();

            return $this->result['Template'];
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send mail template
     *
     * @param string $sender
     * @param array $data
     * @param array $bccAddresses
     * @return array
     */
    public function sendTemplatedEmail(
        string $sender,
        array $data,
        array $bccAddresses= []
    ) {
        try {
            $this->result = $this->ses->sendTemplatedEmail([
                'Source'       => $sender,
                'Template'     => $this->template,
                'TemplateData' => json_encode($data),
                'Destination'  => [
                    'ToAddresses'  => $this->recipients,
                    'BccAddresses' => $bccAddresses
                ]
            ])->toArray();

            return $this->getResponse();
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send Bulk Templated Email
     *
     * @param string $sender
     * @return array
     */
    public function sendBulkTemplatedEmail(string $sender)
    {
        try {
            $response     = [];
            $destinations = $this->getDestinations();

            if (empty($destinations)) {
                return ['status' => false, 'message' => 'None'];
            }

            $defaultData = $this->getDefaultData();

            foreach (array_chunk($destinations, $this->maxDestination) as $data) {
                $this->result = $this->ses->sendBulkTemplatedEmail([
                    'Source'               => $sender,
                    'Template'             => $this->template,
                    'ConfigurationSetName' => $this->configurationSet,
                    'DefaultTemplateData'  => json_encode($defaultData),
                    'Destinations'         => $data,
                ])->toArray();

                $response = $this->getResponse();
            }

            return $response;
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Create Mail Template on SES
     *
     * @param string $templateName
     * @param string $subject
     * @param string $htmlBody
     * @param string $plaintext
     * @return mixed
     */
    public function createMailTemplate(string $templateName, string $subject, string $htmlBody, string $plaintext = '')
    {
        try {
            $this->result = $this->ses->createTemplate([
                'Template' => [
                    'HtmlPart'     => $htmlBody,
                    'SubjectPart'  => $subject,
                    'TemplateName' => $templateName,
                    'TextPart'     => $plaintext,
                ],
            ])->toArray();

            return $this->getResponse();
        } catch (AwsException $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Setup response
     *
     * @return array
     */
    protected function getResponse()
    {
        if ($this->result['@metadata']['statusCode'] != Response::HTTP_OK) {
            Log::channel('mail')->error('Send mail failed');
        }

        return ($this->result['@metadata']['statusCode'] == Response::HTTP_OK)
            ? ['status' => true, 'message' => 'Send mail succeed']
            : ['status' => false, 'message' => 'Send mail failed'];
    }

    /**
     * Get default data for bulk ses sending
     *
     * @return array
     */
    protected function getDefaultData()
    {
        $defaultData = [];

        foreach (array_keys(collect($this->dataDestinations)->first()) as $key) {
            $defaultData[$key] = StringHelper::randomStr();
        }

        return $defaultData;
    }

    /**
     * Get destinations
     *
     * @return array
     */
    protected function getDestinations()
    {
        $destinations = [];

        collect($this->dataDestinations)->each(function ($data, $key) use (&$destinations) {
            if (isset($this->recipients[$key])) {
                foreach (array_chunk($this->recipients[$key], $this->sendRate) as $recipients) {
                    foreach ($recipients as $recipient) {
                        $destinations[] = [
                            'Destination'             => [
                                'ToAddresses' => [$recipient],
                            ],
                            'ReplacementTemplateData' => json_encode($data),
                        ];
                    }
                }
            }
        });

        return $destinations;
    }
}
