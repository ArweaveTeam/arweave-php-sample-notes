<?php
chdir(__DIR__);

require __DIR__ . '/vendor/autoload.php';

use Arweave\SDK\Arweave;
use Arweave\SDK\Support\Wallet;

/**
 * Get an Arweave object for interacting with the network.
 *
 * @return \Arweave\SDK\Arweave
 */
function getArweave(): Arweave
{
    $nodes = json_decode(file_get_contents(__DIR__ . '/storage/nodes.json'), true);

    return new Arweave($nodes[array_rand($nodes)]);
}

/**
 * Get a Wallet object for submitting data to the network.
 *
 * @return \Arweave\SDK\Support\Wallet
 */
function getWallet(): Wallet
{
    $wallet_path = __DIR__ . '/storage/wallet.json';

    if (!file_exists($wallet_path) || !is_readable($wallet_path)) {
        throw new Exception('Could not read wallet file: ' . $wallet_path);
    }

    if (!file_get_contents($wallet_path)) {
        throw new Exception('Wallet file is empty: ' . $wallet_path);
    }

    if (!json_decode(file_get_contents($wallet_path), true)) {
        throw new Exception('Wallet file contents corrupt: ' . $wallet_path);
    }

    return new Wallet(json_decode(file_get_contents($wallet_path), true));
}

/**
 * Get an array of notes from the storage/notes.json file.
 *
 * Array structure:
 *
 * [
 *     [
 *         'subject' => '...',
 *         'date' => '...'
 *         'id' => '...'
 *     ],
 *     ...
 * ]
 *
 * @return mixed[]
 */
function listNotes(): array
{
    $notes_path = __DIR__ . '/storage/notes.json';

    if (!file_exists($notes_path)) {
        if (!@file_put_contents($notes_path, json_encode([]))) {
            throw new Exception('Could not read/create notes file: ' . $notes_path);
        }
    }

    return json_decode(file_get_contents($notes_path), true);
}

/**
 * Get a note from the Arweave network.
 *
 * [
 *     'date' => '...',
 *     'subject' => '...',
 *     'body' => '...',
 * ]
 *
 * @param  string $note_id
 *
 * @return string[]|null
 */
function getNote(string $note_id)
{
    return json_decode(getArweave()->getData($note_id, true), true);
}

/**
 * Save a note on the Arweave network.
 *
 * @param  string $subject Note subject
 * @param  string $body    Note body
 *
 * @throws Exception
 *
 * @return null
 */
function saveNote(string $subject, string $body)
{
    $arweave = getArweave();

    $wallet = getWallet();

    $date = (new DateTime)->format('Y-m-d H:i:s');

    $transaction = $arweave->createTransaction($wallet, json_encode([
        'body'    => $body,
        'subject' => $subject,
        'date'    => $date,
    ]));

    $arweave->commit($transaction);

    $notes = json_decode(file_get_contents(__DIR__ . '/storage/notes.json'), true) ?: [];

    $notes[] = [
        'subject' => $subject,
        'date'    => $date,
        'id'      => $transaction->getAttributes()['id'],
    ];

    file_put_contents(__DIR__ . '/storage/notes.json', json_encode($notes));
}

function dd($var = null)
{
    var_dump($var);
    exit;
}
