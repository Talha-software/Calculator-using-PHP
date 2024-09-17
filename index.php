<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calculator</title>
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
  <?php
  session_start();

  if (!isset($_SESSION['currentNumber'])) {
    $_SESSION['currentNumber'] = '';
  }

  if (!isset($_SESSION['previousNumber'])) {
    $_SESSION['previousNumber'] = '';
  }

  if (!isset($_SESSION['operation'])) {
    $_SESSION['operation'] = null;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['number'])) {
      $_SESSION['currentNumber'] .= $_POST['number'];
    }

    if (isset($_POST['operation'])) {
      if ($_SESSION['currentNumber'] !== '') {
        $_SESSION['previousNumber'] = $_SESSION['currentNumber'];
        $_SESSION['currentNumber'] = '';
        $_SESSION['operation'] = $_POST['operation'];
      }
    }

    if (isset($_POST['equals'])) {
      if ($_SESSION['previousNumber'] !== '' && $_SESSION['currentNumber'] !== '') {
        $prev = floatval($_SESSION['previousNumber']);
        $current = floatval($_SESSION['currentNumber']);
        switch ($_SESSION['operation']) {
          case '+':
            $_SESSION['currentNumber'] = $prev + $current;
            break;
          case '-':
            $_SESSION['currentNumber'] = $prev - $current;
            break;
          case '*':
            $_SESSION['currentNumber'] = $prev * $current;
            break;
          case '/':
            if ($current != 0) {
              $_SESSION['currentNumber'] = $prev / $current;
            } else {
              $_SESSION['currentNumber'] = 'Error';
            }
            break;
        }
        $_SESSION['previousNumber'] = '';
        $_SESSION['operation'] = null;
      }
    }

    if (isset($_POST['clear'])) {
      $_SESSION['currentNumber'] = '';
      $_SESSION['previousNumber'] = '';
      $_SESSION['operation'] = null;
    }
  }

  $display = $_SESSION['currentNumber'] === '' ? '0' : $_SESSION['currentNumber'];
  ?>

  <div class="calculator">
    <h1 class="title">CALCULATOR</h1>
    <div class="display"><?php echo $display; ?></div>
    <form method="post">
      <div>
        <button class="button" name="number" value="7">7</button>
        <button class="button" name="number" value="8">8</button>
        <button class="button" name="number" value="9">9</button>
        <button class="button operator" name="operation" value="+">+</button>
      </div>
      <div>
        <button class="button" name="number" value="4">4</button>
        <button class="button" name="number" value="5">5</button>
        <button class="button" name="number" value="6">6</button>
        <button class="button operator" name="operation" value="-">-</button>
      </div>
      <div>
        <button class="button" name="number" value="1">1</button>
        <button class="button" name="number" value="2">2</button>
        <button class="button" name="number" value="3">3</button>
        <button class="button operator" name="operation" value="*">*</button>
      </div>
      <div>
        <button class="button operator" name="operation" value="/">/</button>
        <button class="button" name="number" value="0">0</button>
        <button class="button clear" name="clear" value="clear">C</button>
        <button class="button equals" name="equals" value="equals">=</button>
      </div>
    </form>
  </div>
</body>

</html>