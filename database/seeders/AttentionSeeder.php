<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttentionChannel;
use App\Models\AttentionQueue;
use App\Models\AttentionExecutive;

class AttentionSeeder extends Seeder
{
    public function run(): void
    {
        // Canal: Presencial
        $presencial = AttentionChannel::create(['name' => 'Presencial']);
        $taquilla = AttentionQueue::create(['attention_channel_id' => $presencial->id, 'name' => 'Taquilla General']);
        AttentionExecutive::create(['attention_queue_id' => $taquilla->id, 'name' => 'Ana Pérez']);
        AttentionExecutive::create(['attention_queue_id' => $taquilla->id, 'name' => 'Luis Rivas']);

        $especializada = AttentionQueue::create(['attention_channel_id' => $presencial->id, 'name' => 'Atención Especializada']);
        AttentionExecutive::create(['attention_queue_id' => $especializada->id, 'name' => 'María Rodriguez']);

        // Canal: Telefónica
        $telefonica = AttentionChannel::create(['name' => 'Telefónica']);
        $asista = AttentionQueue::create(['attention_channel_id' => $telefonica->id, 'name' => 'ASISTA']);
        AttentionExecutive::create(['attention_queue_id' => $asista->id, 'name' => 'Carlos Garcia']);
        AttentionExecutive::create(['attention_queue_id' => $asista->id, 'name' => 'Sofia Martinez']);

        $epsdc = AttentionQueue::create(['attention_channel_id' => $telefonica->id, 'name' => 'EPSDC']);
        AttentionExecutive::create(['attention_queue_id' => $epsdc->id, 'name' => 'Jorge Hernandez']);

        // Canal: Virtual
        $virtual = AttentionChannel::create(['name' => 'Virtual']);
        $telegram = AttentionQueue::create(['attention_channel_id' => $virtual->id, 'name' => 'TELEGRAM']);
        AttentionExecutive::create(['attention_queue_id' => $telegram->id, 'name' => 'Bot Asistente Alfa']);

        $whatsapp = AttentionQueue::create(['attention_channel_id' => $virtual->id, 'name' => 'WHATSAPP']);
        AttentionExecutive::create(['attention_queue_id' => $whatsapp->id, 'name' => 'Bot Asistente Beta']);
        AttentionExecutive::create(['attention_queue_id' => $whatsapp->id, 'name' => 'Laura Gomez']);
    }
}
