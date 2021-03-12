<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Abstracts\StatusTransformer;
use Sylapi\Courier\Enums\StatusType;

class InpostStatusTransformer extends StatusTransformer
{
    /**
     * @var array<string, string>
     */
    public $statuses = [
        'created'                               => StatusType::NEW,
        'offers_prepared'                       => StatusType::ENTRY_WAIT,
        'offer_selected'                        => StatusType::ENTRY_WAIT,
        'confirmed'                             => StatusType::ORDERED,
        'dispatched_by_sender'                  => StatusType::ORDERED,
        'collected_from_sender'                 => StatusType::SENT,
        'taken_by_courier'                      => StatusType::SENT,
        'adopted_at_source_branch'              => StatusType::WAREHOUSE_ENTRY,
        'sent_from_source_branch'               => StatusType::WAREHOUSE_ENTRY,
        'ready_to_pickup_from_pok'              => StatusType::PICKUP_READY,
        'ready_to_pickup_from_pok_registered'   => StatusType::PICKUP_READY,
        'oversized'                             => StatusType::PROCESSING_FAILED,
        'adopted_at_sorting_center'             => StatusType::WAREHOUSE_ENTRY,
        'sent_from_sorting_center'              => StatusType::PROCESSING,
        'adopted_at_target_branch'              => StatusType::PROCESSING,
        'out_for_delivery'                      => StatusType::PICKUP_READY,
        'ready_to_pickup'                       => StatusType::PICKUP_READY,
        'pickup_reminder_sent'                  => StatusType::PICKUP_READY,
        'delivered'                             => StatusType::DELIVERED,
        'pickup_time_expired'                   => StatusType::PROCESSING_FAILED,
        'avizo'                                 => StatusType::PROCESSING_FAILED,
        'claimed'                               => StatusType::SOLVING,
        'returned_to_sender'                    => StatusType::RETURN_DELIVERY,
        'canceled'                              => StatusType::CANCELLED,
        // 'other'                                 => StatusType::NEW,
        'dispatched_by_sender_to_pok'           => StatusType::PROCESSING,
        'out_for_delivery_to_address'           => StatusType::PICKUP_READY,
        'pickup_reminder_sent_address'          => StatusType::PICKUP_READY,
        'rejected_by_receiver'                  => StatusType::PROCESSING_FAILED,
        'undelivered_wrong_address'             => StatusType::RETURNING,
        'undelivered_incomplete_address'        => StatusType::RETURNING,
        'undelivered_unknown_receiver'          => StatusType::RETURNING,
        'undelivered_cod_cash_receiver'         => StatusType::RETURNING,
        'taken_by_courier_from_pok'             => StatusType::WAREHOUSE_ENTRY,
        'undelivered'                           => StatusType::RETURNING,
        'return_pickup_confirmation_to_sender'  => StatusType::DELIVERED,
        'ready_to_pickup_from_branch'           => StatusType::PICKUP_READY,
        'delay_in_delivery'                     => StatusType::PROCESSING,
        'redirect_to_box'                       => StatusType::PICKUP_READY,
        'canceled_redirect_to_box'              => StatusType::PROCESSING_FAILED,
        'readdressed'                           => StatusType::PICKUP_READY,
        'undelivered_no_mailbox'                => StatusType::PROCESSING_FAILED,
        'undelivered_not_live_address'          => StatusType::PROCESSING_FAILED,
        'undelivered_lack_of_access_letterbox'  => StatusType::RETURNING,
        'missing'                               => StatusType::LOST,
        'stack_in_customer_service_point'       => StatusType::PICKUP_READY,
        'stack_parcel_pickup_time_expired'      => StatusType::PROCESSING,
        'unstack_from_customer_service_point'   => StatusType::PROCESSING,
        'courier_avizo_in_customer_service_point' => StatusType::PICKUP_READY,
        'taken_by_courier_from_customer_service_point' => StatusType::RETURNING,
        'stack_in_box_machine'                  => StatusType::PICKUP_READY,
        'unstack_from_box_machine'              => StatusType::PROCESSING,
        'stack_parcel_in_box_machine_pickup_time_expired' => StatusType::PROCESSING
    ];
}
