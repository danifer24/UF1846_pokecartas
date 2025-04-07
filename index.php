<?php


function getPokemonData()
{
    // 1) genera número aleatorio
    $aleatorio = (string) random_int(1, 151);
    // 2) lee el contenido de la api 
    $poke_api = file_get_contents("https://pokeapi.co/api/v2/pokemon/1");
    // 3) lo decodifica
    $poke_json = json_decode($poke_api, true);
    // 4) Creo un objeto pokemon (me quedo sólo con los datos que necesito):
    $pokemon = [
        // nombre (name)
        "nombre" => ucwords($poke_json["name"]),
        // imagen (sprites[front_default])
        "imagen" => $poke_json["sprites"]["front_default"],
        "tipos" => array_map(fn($tipo) => ucwords($tipo['type']['name']), $poke_json["types"]),
        "habilidades" => array_map(fn($tipo) => ucwords($tipo['ability']['name']), $poke_json["abilities"])
    ];

    return $pokemon;
}

$pokemon = getPokemonData();


function renderCards($pokeArray)
{
    global $pokemon;
    // recibe datos y genera el html
    echo "<div class='carta'>
            <div class='img-container'>
                <img src=$pokemon[imagen]>
            </div>
            <div class='datos'>
                <h3>$pokemon[nombre]</h3>
                <div class='tipos-pokemon'>";

    foreach ($pokemon["tipos"] as $key => $tipo) {
        echo "<span>$tipo[$key]</span>";
    }

    echo "</div>
                <ul class='habilidades'>";
    foreach ($pokemon["habilidades"] as $key => $habilidad) {
        echo "<li>$habilidad[$key]</li>";
    }
    echo "</ul>
            </div>
        </div>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeWeb</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>PokeCartas</h1>

    <section id="pokecartas">
        <div class="carta">
            <div class="img-container">
                <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png" alt="pikachu">
            </div>
            <div class="datos">
                <h3>Pikachu</h3>
                <div class="tipos-pokemon">
                    <span>eléctrico</span>
                    <span>otro más</span>
                </div>
                <ul class="habilidades">
                    <li>impactrueno</li>
                    <li>chispitas</li>
                </ul>
            </div>
        </div>

    </section>
    <?php echo "<pre>";
    print_r($pokemon);
    echo "</pre>";
    ?>
    <?php renderCards($pokemon) ?>
   
</body>

</html>