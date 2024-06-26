<?php

namespace App\Listeners;

use App\Mail\ClassCancelMail;
use App\Events\ClassCanceled;
use App\Jobs\NotifyClassCanceledJob;
use App\Notifications\ClassCanceledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;


class NotifyClassCanceled
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassCanceled $event): void
    {
            $members = $event->scheduledClass->members()->get();

            $className = $event->scheduledClass->classType->name;
            $classDateTime = $event->scheduledClass->date_time;

            $details = compact('className', 'classDateTime');

            // $members->each(function($user) use ($details) {
            //     // Send mail
            //     Mail::to($user)->send(new ClassCancelMail($details));
            // });
            
            NotifyClassCanceledJob::dispatch($members, $details);
    }
}
