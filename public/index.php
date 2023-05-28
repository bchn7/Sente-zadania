
<?php

require_once 'class/Order.php';
require_once 'class/OrderRep.php';

$orderRepository = new OrderRep('naglowki_zamowienia.json');

$searchSymbol = isset($_GET['search_symbol']) ? $_GET['search_symbol'] : null;
$searchRef = isset($_GET['search_ref']) ? $_GET['search_ref'] : null;
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'ref_zamowienia';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';

if ($searchSymbol) {
    $orders = $orderRepository->searchBySymbol($searchSymbol);
} elseif ($searchRef) {
    $orders = $orderRepository->searchByRef($searchRef);
} else {
    $orders = $orderRepository->getAllOrders();
}

$orderRepository->sortOrders($sortBy, $sortOrder);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sente</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <h1>Sente Zamówienia</h1>

    <form method="GET" action="index.php" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="search_symbol" class="form-control" placeholder="Symbol zamówienia"
                       value="<?php echo $searchSymbol; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="search_ref" class="form-control" placeholder="Ref zamówienia"
                       value="<?php echo $searchRef; ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Wyszukaj</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>
                <a href="index.php?sort_by=orderRef&sort_order=<?php echo ($sortBy == 'orderRef' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>">
                    Ref zamówienia
                    <?php if ($sortBy == 'orderRef'): ?>
                        <?php if ($sortOrder == 'asc'): ?>
                            <i class="bi bi-sort-up"></i>
                        <?php else: ?>
                            <i class="bi bi-sort-down"></i>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
            </th>
            <th>
                <a href="index.php?sort_by=clientName&sort_order=<?php echo ($sortBy == 'clientName' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>">
                    Nazwa klienta
                    <?php if ($sortBy == 'clientName'): ?>
                        <?php if ($sortOrder == 'asc'): ?>
                            <i class="bi bi-sort-up"></i>
                        <?php else: ?>
                            <i class="bi bi-sort-down"></i>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
            </th>
            <th>
                <a href="index.php?sort_by=registerDate&sort_order=<?php echo ($sortBy == 'registerDate' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>">
                    Data zarejestrowania zamówienia
                    <?php if ($sortBy == 'registerDate'): ?>
                        <?php if ($sortOrder == 'asc'): ?>
                            <i class="bi bi-sort-up"></i>
                        <?php else: ?>
                            <i class="bi bi-sort-down"></i>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
            </th>
            <th>
                <a href="index.php?sort_by=orderSymbol&sort_order=<?php echo ($sortBy == 'orderSymbol' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>">
                    Symbol zamówienia
                    <?php if ($sortBy == 'orderSymbol'): ?>
                        <?php if ($sortOrder == 'asc'): ?>
                            <i class="bi bi-sort-up"></i>
                        <?php else: ?>
                            <i class="bi bi-sort-down"></i>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
            </th>
            <th>
                <a href="index.php?sort_by=sentData&sort_order=<?php echo ($sortBy == 'sentData' && $sortOrder == 'asc') ? 'desc' : 'asc'; ?>">
                    Data wysłania zamówienia
                    <?php if ($sortBy == 'sentData'): ?>
                        <?php if ($sortOrder == 'asc'): ?>
                            <i class="bi bi-sort-up"></i>
                        <?php else: ?>
                            <i class="bi bi-sort-down"></i>
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
            </th>
            <th>Czy zafakturowane</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order->getOrderRef(); ?></td>
                <td><?php echo $order->getClientName(); ?></td>
                <td><?php echo $order->getRegisterDate(); ?></td>
                <td><?php echo $order->getOrderSymbol(); ?></td>
                <td><?php echo $order->getSendDate(); ?></td>
                <td><?php echo $order->isInvoiced() ? 'Tak' : 'Nie'; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>