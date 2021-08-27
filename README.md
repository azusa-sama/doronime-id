<p align="center">
<img src="https://i.pinimg.com/originals/a3/1b/ec/a31becfcb76c2a3d73118c2b7b302b0b.png"  align="center"/>
</p>
<h1 align="center"> Doronime Scraper </h1>
<h4 align="center"> Get Direct Download Link from Doronime.id<br/></h4>
<br/>

---

## Usage
Get data from doronime.id :

```php
// Initializing and Getting data then save to properties variable
$doronime = new Doronime();
$doronime->get_data();

// Get Anime Recommend
$doronime->get_anime();

// Get Update Anime
$doronime->get_anime_update();

// Get Update OST
$doronime->get_ost();

// Get Update Movie
$doronime->get_update_movie();

// Get Ongoing Anime
$doronime->get_ongoing_anime();

// Get Data From All Season
$doronime->get_season();
```

Download from doronime.id

```php
$doronime_dl = new DoronimeDL('url');
$doronime->download();
```

Example : 

```php
$doronime_dl = new DoronimeDL('https://doronime.id/anime/tsuki-ga-michibiku-isekai-douchuu/episode-8');
$doronime->download();
```

DoronimeDL can download OST,Anime and other from Doronime.id
