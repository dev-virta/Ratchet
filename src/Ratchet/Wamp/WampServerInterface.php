<?php
namespace Ratchet\Wamp;
use Ratchet\ComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * An extension of Ratchet\ComponentInterface to server a WAMP application
 * onMessage is replaced by various types of messages for this protocol (pub/sub or rpc)
 */
interface WampServerInterface extends ComponentInterface {
    /**
     * An RPC call has been received
     * @param \Ratchet\ConnectionInterface $conn
     * @param string                       $id The unique ID of the RPC, required to respond to
     * @param string|Topic                 $topic The topic to execute the call against
     * @param array                        $params Call parameters received from the client
     */
    function onCall(ConnectionInterface $conn, $id, $topic, array $params);

	/**
	 * An RPC call result has been received.
	 *
	 * @param ConnectionInterface $conn
	 * @param string $id This must be the exact same id that is in the call request so that the recipient can match request and result.
	 * @param array $params Payload is a JSON object containing the results of the executed Action.
	 */
	function onCallResult(ConnectionInterface $conn, $id, array $params);

	/**
	 * An RPC call error has been received.
	 *
	 * @param ConnectionInterface $conn
	 * @param string $id This must be the exact same id that is in the call request so that the recipient can match request and result.
	 * @param string $errorCode This string must contain one of the from the ErrorCode table below.
	 * @param string $errorDescription Should be filled in if possible, otherwise a clear empty string ''.
	 * @param array $errorDetails This JSON object describes error details in an undefined way. If there are no error details you should fill in an empty object {}, missing or null is not allowed.
	 */
	function onCallError(ConnectionInterface $conn, $id, $errorCode, $errorDescription, array $errorDetails);

    
    /**
     * A request to subscribe to a topic has been made
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic                 $topic The topic to subscribe to
     */
    function onSubscribe(ConnectionInterface $conn, $topic);

    /**
     * A request to unsubscribe from a topic has been made
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic                 $topic The topic to unsubscribe from
     */
    function onUnSubscribe(ConnectionInterface $conn, $topic);

    /**
     * A client is attempting to publish content to a subscribed connections on a URI
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic                 $topic The topic the user has attempted to publish to
     * @param string                       $event Payload of the publish
     * @param array                        $exclude A list of session IDs the message should be excluded from (blacklist)
     * @param array                        $eligible A list of session Ids the message should be send to (whitelist)
     */
    function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible);
}
