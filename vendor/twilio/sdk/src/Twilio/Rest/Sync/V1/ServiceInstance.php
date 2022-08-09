<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Sync\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Sync\V1\Service\DocumentList;
use Twilio\Rest\Sync\V1\Service\SyncListList;
use Twilio\Rest\Sync\V1\Service\SyncMapList;
use Twilio\Rest\Sync\V1\Service\SyncStreamList;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string $sid
 * @property string $uniqueName
 * @property string $accountSid
 * @property string $friendlyName
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 * @property string $url
 * @property string $webhookUrl
 * @property bool $webhooksFromRestEnabled
 * @property bool $reachabilityWebhooksEnabled
 * @property bool $aclEnabled
 * @property bool $reachabilityDebouncingEnabled
 * @property int $reachabilityDebouncingWindow
 * @property array $links
 */
class ServiceInstance extends InstanceResource {
    protected $_documents;
    protected $_syncLists;
    protected $_syncMaps;
    protected $_syncStreams;

    /**
     * Initialize the ServiceInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid The SID of the Service resource to fetch
     */
    public function __construct(Version $version, array $payload, string $sid = null) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'sid' => Values::array_get($payload, 'sid'),
            'uniqueName' => Values::array_get($payload, 'unique_name'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'friendlyName' => Values::array_get($payload, 'friendly_name'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'url' => Values::array_get($payload, 'url'),
            'webhookUrl' => Values::array_get($payload, 'webhook_url'),
            'webhooksFromRestEnabled' => Values::array_get($payload, 'webhooks_from_rest_enabled'),
            'reachabilityWebhooksEnabled' => Values::array_get($payload, 'reachability_webhooks_enabled'),
            'aclEnabled' => Values::array_get($payload, 'acl_enabled'),
            'reachabilityDebouncingEnabled' => Values::array_get($payload, 'reachability_debouncing_enabled'),
            'reachabilityDebouncingWindow' => Values::array_get($payload, 'reachability_debouncing_window'),
            'links' => Values::array_get($payload, 'links'),
        ];

        $this->solution = ['sid' => $sid ?: $this->properties['sid'], ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return ServiceContext Context for this ServiceInstance
     */
    protected function proxy(): ServiceContext {
        if (!$this->context) {
            $this->context = new ServiceContext($this->version, $this->solution['sid']);
        }

        return $this->context;
    }

    /**
     * Fetch the ServiceInstance
     *
     * @return ServiceInstance Fetched ServiceInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ServiceInstance {
        return $this->proxy()->fetch();
    }

    /**
     * Delete the ServiceInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool {
        return $this->proxy()->delete();
    }

    /**
     * Update the ServiceInstance
     *
     * @param array|Options $options Optional Arguments
     * @return ServiceInstance Updated ServiceInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): ServiceInstance {
        return $this->proxy()->update($options);
    }

    /**
     * Access the documents
     */
    protected function getDocuments(): DocumentList {
        return $this->proxy()->documents;
    }

    /**
     * Access the syncLists
     */
    protected function getSyncLists(): SyncListList {
        return $this->proxy()->syncLists;
    }

    /**
     * Access the syncMaps
     */
    protected function getSyncMaps(): SyncMapList {
        return $this->proxy()->syncMaps;
    }

    /**
     * Access the syncStreams
     */
    protected function getSyncStreams(): SyncStreamList {
        return $this->proxy()->syncStreams;
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name) {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Sync.V1.ServiceInstance ' . \implode(' ', $context) . ']';
    }
}