<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Klasa obsługująca połączenia WebSocket
class GameServer implements MessageComponentInterface
{
    protected $clients;
    protected $players;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->players = []; // Tutaj można przechowywać stany gier
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Dodajemy klienta do listy połączonych klientów
        $this->clients->attach($conn);
        echo "Nowe połączenie! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // Przyjmujemy wiadomość od klienta
        $data = json_decode($msg, true);

        // Przykład: obsługa ruchu gracza
        if (isset($data['action']) && $data['action'] === 'move') {
            // Tutaj można zaimplementować logikę zapisu ruchu do stanu gry (np. bazy danych)
            // i wysyłanie aktualizacji do wszystkich podłączonych klientów
            foreach ($this->clients as $client) {
                $client->send($msg); // Przesłanie wiadomości do klienta
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Usuwamy klienta z listy połączonych klientów
        $this->clients->detach($conn);
        echo "Klient odłączył się ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Błąd: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Uruchamiamy serwer WebSocket
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new GameServer()
        )
    ),
    8080 // Port serwera WebSocket
);

echo "Serwer WebSocket uruchomiony na port 8080...\n";

// Uruchomienie serwera
$server->run();
