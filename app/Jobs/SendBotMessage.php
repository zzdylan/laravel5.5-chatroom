<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GatewayClient\Gateway;
use App\Lib\TuLing;

class SendBotMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $text;
    protected $uid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($text,$uid)
    {
        $this->text = $text;
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Gateway::$registerAddress = '127.0.0.1:1238';
        $tuLing = new TuLing();
        $botText = $tuLing->bot($this->text,$this->uid);
        $pushData = ['type' => 'text', 'content' => $botText, 'nickname' => '小艺', 'avatar' => 'http://7xwe54.com1.z0.glb.clouddn.com/logo.jpg'];
        Gateway::sendToAll(json_encode($pushData));
    }
}
