<?php

class OrderRep
{
    private $orders;

    // W konstruktorze pobieramy plik json i przypisujemy do tablicy $item zawartość poszczegolnych pol 
    public function __construct($jsonFile){
        $readFile = file_get_contents($jsonFile);
        $data = json_decode($readFile, true);

        $this->orders = [];

        foreach ($data as $item) {
            $order = new Order(
                $item['ref'],
                $item['client_name'],
                $item['regdate'],
                $item['symbol'],
                $item['send_date'],
                $item['invoiced']
            );

            $this->orders[] = $order;
        }
    }

    // funkcja zwracajaca wszystkie zamowienia
    public function getAllOrders(){
        return $this->orders;
    }

    // funkcja wyszukujaca poprzez symbol
    public function searchBySymbol($orderSymbol){
        return array_filter($this->orders, function ($order) use ($orderSymbol){
            return strpos($order->getOrderSymbol(), $orderSymbol) !== false;
        });

    }

    // funkcja wyszukujaca poprzez referencje
    public function searchByRef($ref){
        return array_filter($this->orders, function ($order) use ($ref) {
            return strpos($order->getOrderRef(), $ref) !== false;
        });
    }

    // Funkcja zwracajac wartosc pola
    private function getFieldValue($order, $field)
    {
        switch ($field) {
            case 'ref':
                return $order->getOrderRef();
            case 'client_name':
                return $order->getClientName();
            case 'regdate':
                return $order->getRegisterDate();
            case 'symbol':
                return $order->getOrderSymbol();
            case 'send_date':
                return $order->getSendDate();
            default:
                return null;
        }
    }

    // Funkcja sortujaca uzywajaca anonimowej funkcji do sortowania poprzez pole $field w zaleznosci od tego co jest w $order
    public function sortOrders($field, $order)
    {
        usort($this->orders, function ($a, $b) use ($field, $order) {
            $valueA = $this->getFieldValue($a, $field);
            $valueB = $this->getFieldValue($b, $field);

            if ($valueA == $valueB) {
                return 0;
            }

            if ($order === 'asc') {
                return ($valueA < $valueB) ? -1 : 1;
            }

            return ($valueA > $valueB) ? -1 : 1;
        });
    }
}