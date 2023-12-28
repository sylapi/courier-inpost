<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Abstracts\StatusTransformer as StatusTransformerAbstract;
use Sylapi\Courier\Enums\StatusType;

class StatusTransformer extends StatusTransformerAbstract
{
    /**
     * @var array<string, string>
     */
    public $statuses = [
        'created'                               => StatusType::NEW->value,
        'offers_prepared'                       => StatusType::ENTRY_WAIT->value,
        'offer_selected'                        => StatusType::ENTRY_WAIT->value,
        'confirmed'                             => StatusType::ORDERED->value,
        'dispatched_by_sender'                  => StatusType::ORDERED->value,
        'collected_from_sender'                 => StatusType::SENT->value,
        'taken_by_courier'                      => StatusType::SENT->value,
        'adopted_at_source_branch'              => StatusType::WAREHOUSE_ENTRY->value,
        'sent_from_source_branch'               => StatusType::WAREHOUSE_ENTRY->value,
        'ready_to_pickup_from_pok'              => StatusType::PICKUP_READY->value,
        'ready_to_pickup_from_pok_registered'   => StatusType::PICKUP_READY->value,
        'oversized'                             => StatusType::PROCESSING_FAILED->value,
        'adopted_at_sorting_center'             => StatusType::WAREHOUSE_ENTRY->value,
        'sent_from_sorting_center'              => StatusType::PROCESSING->value,
        'adopted_at_target_branch'              => StatusType::PROCESSING->value,
        'out_for_delivery'                      => StatusType::PICKUP_READY->value,
        'ready_to_pickup'                       => StatusType::PICKUP_READY->value,
        'pickup_reminder_sent'                  => StatusType::PICKUP_READY->value,
        'delivered'                             => StatusType::DELIVERED->value,
        'pickup_time_expired'                   => StatusType::PROCESSING_FAILED->value,
        'avizo'                                 => StatusType::PROCESSING_FAILED->value,
        'claimed'                               => StatusType::SOLVING->value,
        'returned_to_sender'                    => StatusType::RETURN_DELIVERY->value,
        'canceled'                              => StatusType::CANCELLED->value,
        // 'other'                                 => StatusType::NEW,
        'dispatched_by_sender_to_pok'                     => StatusType::PROCESSING->value,
        'out_for_delivery_to_address'                     => StatusType::PICKUP_READY->value,
        'pickup_reminder_sent_address'                    => StatusType::PICKUP_READY->value,
        'rejected_by_receiver'                            => StatusType::PROCESSING_FAILED->value,
        'undelivered_wrong_address'                       => StatusType::RETURNING->value,
        'undelivered_incomplete_address'                  => StatusType::RETURNING->value,
        'undelivered_unknown_receiver'                    => StatusType::RETURNING->value,
        'undelivered_cod_cash_receiver'                   => StatusType::RETURNING->value,
        'taken_by_courier_from_pok'                       => StatusType::WAREHOUSE_ENTRY->value,
        'undelivered'                                     => StatusType::RETURNING->value,
        'return_pickup_confirmation_to_sender'            => StatusType::DELIVERED->value,
        'ready_to_pickup_from_branch'                     => StatusType::PICKUP_READY->value,
        'delay_in_delivery'                               => StatusType::PROCESSING->value,
        'redirect_to_box'                                 => StatusType::PICKUP_READY->value,
        'canceled_redirect_to_box'                        => StatusType::PROCESSING_FAILED->value,
        'readdressed'                                     => StatusType::PICKUP_READY->value,
        'undelivered_no_mailbox'                          => StatusType::PROCESSING_FAILED->value,
        'undelivered_not_live_address'                    => StatusType::PROCESSING_FAILED->value,
        'undelivered_lack_of_access_letterbox'            => StatusType::RETURNING->value,
        'missing'                                         => StatusType::LOST->value,
        'stack_in_customer_service_point'                 => StatusType::PICKUP_READY->value,
        'stack_parcel_pickup_time_expired'                => StatusType::PROCESSING->value,
        'unstack_from_customer_service_point'             => StatusType::PROCESSING->value,
        'courier_avizo_in_customer_service_point'         => StatusType::PICKUP_READY->value,
        'taken_by_courier_from_customer_service_point'    => StatusType::RETURNING->value,
        'stack_in_box_machine'                            => StatusType::PICKUP_READY->value,
        'unstack_from_box_machine'                        => StatusType::PROCESSING->value,
        'stack_parcel_in_box_machine_pickup_time_expired' => StatusType::PROCESSING->value,
    ];
}
