<?php
//session_start();

class btnFiltra {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli("127.0.0.1", "programma1", "12345", "centro_massaggi");
        if ($this->connection->connect_error) {
            die("Connessione al database fallita: " . $this->connection->connect_error);
        }
    }

    public function Form1_Load() {
        $this->CaricaDatiPrestazioni();
        $this->CaricaDatiMassaggiatrici();
    }

    private function CaricaDatiPrestazioni() {
        echo "<h2>Dati Prestazioni</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Tipo</th><th>Costo</th><th>ID Massaggiatrice</th></tr>";
        $query = "SELECT id, tipo, costo, id_massaggiatrice FROM prestazione";
        $result = $this->connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["id"]."</td><td>".$row["tipo"]."</td><td>".$row["costo"]."</td><td>".$row["id_massaggiatrice"]."</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nessun risultato trovato per le prestazioni.</td></tr>";
        }
        echo "</table>";
    }

    private function CaricaDatiMassaggiatrici() {
        echo "<h2>Dati Massaggiatrici</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Nome</th><th>Età</th></tr>";
        $query = "SELECT id, nome, eta FROM massaggiatrici";
        $result = $this->connection->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["id"]."</td><td>".$row["nome"]."</td><td>".$row["eta"]."</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nessun risultato trovato per le massaggiatrici.</td></tr>";
        }
        echo "</table>";
    }

    public function FiltraPerCosto($costoFiltro) {
        echo "<h2>Risultati Filtrati per Costo</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Tipo</th><th>Costo</th><th>ID Massaggiatrice</th></tr>";
        $query = "SELECT id, tipo, costo, id_massaggiatrice FROM prestazione WHERE costo <= ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $costoFiltro);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["id"]."</td><td>".$row["tipo"]."</td><td>".$row["costo"]."</td><td>".$row["id_massaggiatrice"]."</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nessun risultato trovato per il filtro di costo $costoFiltro.</td></tr>";
        }
        echo "</table>";
        $stmt->close();
    }

    public function AggiungiMassaggiatrice($nome, $eta) {
        $query = "INSERT INTO massaggiatrici (nome, eta) VALUES (?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("si", $nome, $eta);
        $stmt->execute();
        $stmt->close();
    }

    public function AggiungiPrestazione($tipo, $costo, $id_massaggiatrice) {
        $query = "INSERT INTO prestazione (tipo, costo, id_massaggiatrice) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sii", $tipo, $costo, $id_massaggiatrice);
        $stmt->execute();
        $stmt->close();
    }

    public function ModificaMassaggiatrice($id, $nome, $eta) {
        $query = "UPDATE massaggiatrici SET nome = ?, eta = ? WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sii", $nome, $eta, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function ModificaPrestazione($id, $tipo, $costo) {
        $query = "UPDATE prestazione SET tipo = ?, costo = ? WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sii", $tipo, $costo, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function EliminaMassaggiatrice($id) {
        $query = "DELETE FROM massaggiatrici WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function EliminaPrestazione($id) {
        $query = "DELETE FROM prestazione WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$btnFiltra = new btnFiltra();

if(isset($_POST['costoFiltro'])) {
    $costoFiltro = $_POST['costoFiltro'];
    $btnFiltra->FiltraPerCosto($costoFiltro);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Centro Massaggi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }
        input[type=text], input[type=number] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
        }
        input[type=submit] {
            background-color: #EE82EE;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #EE82EE;
        }
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<h1>Caricamento dei Dati</h1>
<?php $btnFiltra->Form1_Load(); ?>
<h2>Filtra per Costo</h2>
<form method="post">
    Costo Massimo: <input type="number" name="costoFiltro" required><br>
    <input type="submit" value="Filtra">
</form>
<h2>Aggiungi Massaggiatrice</h2>
<form method="post">
    Nome: <input type="text" name="nomeMassaggiatrice" required><br>
    Età: <input type="number" name="etaMassaggiatrice" required><br>
    <input type="submit" value="Aggiungi">
</form>
<h2>Aggiungi Prestazione</h2>
<form method="post">
    Tipo: <input type="text" name="tipoPrestazione" required><br>
    Costo: <input type="number" name="costoPrestazione" required><br>
    ID Massaggiatrice: <input type="number" name="idMassaggiatrice" required><br>
    <input type="submit" value="Aggiungi">
</form>
<h2>Elimina Massaggiatrice o Prestazione</h2>
<form method="post">
    Tipo:
    <select name="eliminaTipo" required>
        <option value="massaggiatrice">Massaggiatrice</option>
        <option value="prestazione">Prestazione</option>
    </select><br>
    ID: <input type="number" name="eliminaID" required><br>
    <input type="submit" value="Elimina">
</form>
<h2>Modifica Massaggiatrice</h2>
<form method="post">
    ID Massaggiatrice: <input type="number" name="idMassaggiatriceModifica" required><br>
    Nuovo Nome: <input type="text" name="nomeMassaggiatriceModifica" required><br>
    Nuova Età: <input type="number" name="etaMassaggiatriceModifica" required><br>
    <input type="submit" name="modificaMassaggiatrice" value="Modifica">
</form>
<h2>Modifica Prestazione</h2>
<form method="post">
    ID Prestazione: <input type="number" name="idPrestazioneModifica" required><br>
    Nuovo Tipo: <input type="text" name="tipoPrestazioneModifica" required><br>
    Nuovo Costo: <input type="number" name="costoPrestazioneModifica" required><br>
    <input type="submit" name="modificaPrestazione" value="Modifica">
</form>

</body>
</html>
