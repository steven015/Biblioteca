<?php
class Libro {
    //Atributos de la clase Libro
    private $id;
    private $titulo;
    private $autor;
    private $genero;
    private $estado;

    //
    //Constructor de la clase Libro
    public function __construct($id, $titulo, $autor, $genero, $estado = "disponible") {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->genero = $genero;
        $this->estado = $estado;
    }

    //Metodos setters y getters
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function setAutor($autor) {
        $this->autor = $autor;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function editarLibro($titulo, $autor, $genero) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->genero = $genero;
    }
}

class Biblioteca {
    private $libro = [];

    public function agregarLibro($libro) {
        $this->libro[$libro->getId()] = $libro;
    }

    public function editarLibro($id, $nuevoTitulo, $nuevoAutor, $nuevoGenero) {
        if (isset($this->libro[$id])) {
            $this->libro[$id]->editarLibro($nuevoTitulo, $nuevoAutor, $nuevoGenero);
        }
    }

    public function eliminarLibro($id) {
        if (isset($this->libro[$id])) {
            unset($this->libro[$id]);
        }
    }

    public function buscarLibro($criterio) {
        $resultados = [];
        foreach ($this->libro as $libro) {
            if (stripos($libro->getTitulo(), $criterio) !== false || stripos($libro->getAutor(), $criterio) !== false || stripos($libro->getGenero(), $criterio) !== false) {
                $resultados[] = $libro;
            }
        }
        return $resultados;
    }

    public function prestarLibro($id) {
        if (isset($this->libro[$id]) && $this->libro[$id]->getEstado() === "disponible") {
            $this->libro[$id]->setEstado("prestado");
            return true;
        }
        return false;
    }

    public function regresarLibro($id) {
        if (isset($this->libro[$id]) && $this->libro[$id]->getEstado() === "prestado") {
            $this->libro[$id]->setEstado("disponible");
            return true;
        }
        return false;
    }

    public function disponibleLibros() {
        $disponibles = [];
        foreach ($this->libro as $libro) {
            if ($libro->getEstado() === "disponible") {
                $disponibles[] = $libro;
            }
        }
        return $disponibles;
    }

    public function seleccionarLibro() {
        return $this->libro;
    }
}


$biblioteca = new Biblioteca();

$libro1 = new Libro(1,"La riada", "Michael MCDOWEL ", "Novela");
$libro2 = new Libro(2,"La grieta del silencio", "Javier Castillo", "Novela");
$libro3 = new Libro(3,"Recupera tu mente, conquista tu vida", "Marian Rojas Estapé", "Motivacional");
$libro4 = new Libro(4,"Metamorfosis", "Franz Kafka", "fantasia");
$libro5 = new Libro(5,"Hamlet", "William Shakespeare", "tragedia");
$libro6 = new Libro(6,"Una historia Particular", "Manuel Vincent", "Bibliografico");
$libro7 = new Libro(7,"El señor de los anillos, las dos torres", "J.K. Rowling", "Fantasía");
$libro8 = new Libro(8,"Harry Potter y la camara de los secretos", "J.R.R. Tolkien", "Fantasía");

$biblioteca->agregarLibro($libro1);
$biblioteca->agregarLibro($libro2);
$biblioteca->agregarLibro($libro3);
$biblioteca->agregarLibro($libro4);
$biblioteca->agregarLibro($libro5);
$biblioteca->agregarLibro($libro6);

$biblioteca->prestarLibro(4);

$librosDisponibles = $biblioteca->disponibleLibros();
echo "libros disponibles actualmente, ojala no se roben los que se prestan: \n";
foreach ($librosDisponibles as $libro) {
    echo "ID: " . $libro->getId() . " - titulo del libro: " . $libro->getTitulo() . " - Autor: " . $libro->getAutor() . "\n";
}

$biblioteca->regresarLibro(4);

$librosDisponibles = $biblioteca->disponibleLibros();
echo "libros disponibles actualmente, no te los robes si los prestas:\n";
foreach ($librosDisponibles as $libro) {
    echo "ID: " . $libro->getId() . " - titulo del libro: " . $libro->getTitulo() . " - Autor: " . $libro->getAutor() . "\n";
}
?>