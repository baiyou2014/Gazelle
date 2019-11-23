<?php
define('LIMIT', 100);

//$Limit = isset($_GET['limit']) ? intval($_GET['limit']) : 100;
//$Limit = in_array($Limit, array(100, 250, 500)) ? $Limit : 100;


$Category = isset($_GET['category']) ? $_GET['category'] : 'weekly';
$Category = in_array($Category, array('all_time', 'weekly', 'hyped')) ? $Category : 'weekly';

$View = isset($_GET['view']) ? $_GET['view'] : 'tiles';
$View = in_array($View, array('tiles', 'list')) ? $View : 'tiles';

switch ($Category) {
    case 'weekly':
        $Artists = json_decode(LastFM::get_weekly_artists(LIMIT), true)['artists']['artist'];
        break;
    case 'hyped':
        $Artists = json_decode(LastFM::get_hyped_artists(LIMIT), true)['artists']['artist'];
        break;
    default:
        break;
}

View::show_header("Last.fm", "jquery.imagesloaded,jquery.wookmark,top10", "tiles");
?>
<div class="thin">
    <div class="header">
        <h2>Last.fm</h2>
<?php   Top10View::render_linkbox("lastfm"); ?>
    </div>
<?php    Top10View::render_artist_links($Category, $View); ?>
<?php    Top10View::render_artist_controls($Category, $View); ?>
<?php   if ($View == 'tiles') { ?>
        <div class="tiles_container">
            <ul class="tiles">
<?php
            foreach ($Artists as $Artist) {
                    Top10View::render_artist_tile($Artist, $Category);
            }
?>
            </ul>
        </div>
<?php    } else { ?>
        <div class="list_container">
            <ul class="top_artist_list">
<?php
            foreach ($Artists as $Artist) {
                    Top10View::render_artist_list($Artist, $Category);
            }
?>
            </ul>
        </div>
<?php   } ?>
    </div>
<?php
View::show_footer();
?>
