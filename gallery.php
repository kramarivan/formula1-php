<?php
print '
<h1>Gallery of Teams</h1>
<div id="gallery">';
$teams = [
    1 => 'Red Bull',
    2 => 'Ferrari',
    3 => 'Mercedes',
    4 => 'Alpine',
    5 => 'McLaren',
    6 => 'Alfa Romeo',
    7 => 'Aston Martin',
    8 => 'Haas',
    9 => 'AlphaTauri',
    10 => 'Williams'
];

foreach ($teams as $id => $team) {
    echo '<figure id="' . $id . '">
            <img src="gallery/team' . $id . '.jpeg" alt="' . $team . '" title="' . $team . '">
            <figcaption>' . $team . '</figcaption>
        </figure>';
}
print '
</div>';
?>