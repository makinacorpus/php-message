<?php

declare (strict_types=1);

namespace MakinaCorpus\Message\Property;

/**
 * From "AMQP Specification v1.0" (revision 1350, page 77):
 *
 *   <type name="properties" class="composite" source="list" provides="section">
 *     <descriptor name="amqp:properties:list" code="0x00000000:0x00000073"/>
 *     <field name="message-id" type="*" requires="message-id"/>
 *     <field name="user-id" type="binary"/>
 *     <field name="to" type="*" requires="address"/>
 *     <field name="subject" type="string"/>
 *     <field name="reply-to" type="*" requires="address"/>
 *     <field name="correlation-id" type="*" requires="message-id"/>
 *     <field name="content-type" type="symbol"/>
 *     <field name="content-encoding" type="symbol"/>
 *     <field name="absolute-expiry-time" type="timestamp"/>
 *     <field name="creation-time" type="timestamp"/>
 *     <field name="group-id" type="string"/>
 *     <field name="group-sequence" type="sequence-no"/>
 *     <field name="reply-to-group-id" type="string"/>
 *   </type>
 *
 * Application properties definition:
 *
 *   The application-properties section is a part of the bare message used for
 *   structured application data. Intermediaries may use the data within this
 *   structure for the purposes of filtering or routing.
 *
 *   The keys of this map are restricted to be of type string (which excludes
 *   the possibility of a null key) and the values are restricted to be of
 *   simple types only, that is (excluding map, list, and array types).
 */
class PropertyAmqp1_0
{
    const MESSAGE_ID = 'message-id';
    const USER_ID = 'user_id';
    const TO = 'to';
    const SUBJECT = 'subject';
    const REPLY_TO = 'reply-to';
    const CORRELATION_ID = 'correlation-id';
    const CONTENT_TYPE = 'content-type';
    const CONTENT_ENCODING = 'content-encoding';
    const ABSOLUTE_EXPIRY_TIME = 'absolute-expiry-time';
    const CREATION_TIME = 'creation-time';
    const GROUP_ID = 'group-id';
    const GROUP_SEQUENCE = 'groupe-sequence';
    const REPLY_TO_GROUP_ID = 'reply-to-group-id';
}
