<?php
class Doronime
{
    public $url, $html, $type = array();
    public function __construct($url = 'https://doronime.id/')
    {
        $this->url = $url;
        $this->html = file_get_contents($this->url);
    }

    public function get_data()
    {
        $html = str_get_html($this->html);
        $array = array();
        foreach ($html->find('div.Content__tabs') as $loop) {
            $span = $loop->find('span', 0);
            $body = $loop->find('div.Content__tabs-body', 0);
            $return = array();
            if (!empty($span->innertext)) {
                $return = array('span' => $span->innertext);
                $get = array();
                foreach ($loop->find('div.Content__tabs-body') as $base) {
                    $return['body'] = htmlspecialchars_decode($base->innertext, ENT_QUOTES);
                }
                array_push($array, $return);
            }
        }
        foreach ($array as $key) {
            if ($key['span'] == $key['span']) {
                $replace  = str_replace(' ', '_', $key['span']);
                $this->type[strtolower($replace)] = $key;
            }
        }
    }

    public function get_anime($html = "")
    {
        $html = str_get_html($this->type['anime']['body']);
        $return = array();
        foreach ($html->find('a') as $anchor) {
            $href = $anchor->outertext;
            preg_match_all('#href="(.*?)"#', $href, $url);
            preg_match_all('#<small>(.*?)</small>#', $href, $title);
            preg_match_all('#<img src="(.*?)"#', $href, $img);
            preg_match_all('#<div class="Card__badge">(.*?)</div>#', $href, $status);
            preg_match_all('#<span class="Badge Badge--small Badge--warning">(.*?)</span>#', $href, $score);

            $array = array(
                'title' => $title[1][0],
                'status' => (isset($status[1][0])) ? trim(strip_tags($status[1][0])) : '',
                'score' => (isset($score[1][0])) ? trim(strip_tags($score[1][0])) : '',
                'url' => $url[1][0],
                'images' => $img[1][0]
            );
            $return[] = $array;
        }
        echo json_encode(array(
            'section' => 'Anime Recommend',
            'data' => $return
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function get_anime_update($html = "")
    {
        $html = str_get_html($this->type['update_anime']['body']);
        $return = array();
        foreach ($html->find('div.col-6') as $col) {
            $crd_img = $col->find('div.Card__image', 0)->innertext;
            preg_match_all('#<picture>(.*?)</picture>#', $crd_img, $matches);
            preg_match_all('#<source type="image/webp" srcset="(.*?)"#', $matches[1][0], $img);
            $crd_cpt = $col->find('div.Card__caption', 0)->innertext;
            preg_match_all('/<a[^>]*href="(.*?)"[^>]*>(.*?)<\/a>/i', $crd_cpt, $anchor);
            preg_match_all('#<small>(.*?)</small>#', $crd_cpt, $time);
            $times = trim(strip_tags($time[1][0]));
            $url = $anchor[1][0];
            $title = $anchor[2][0];
            $img_url = str_replace('_SM', '', $img[1][0]);
            $array = array(
                'title' => $title,
                'update_time' => $times,
                'img_url' => $img_url,
                'post_url' => $url
            );
            $return[] = $array;
        }
        echo json_encode(array(
            'section' => 'Update Anime',
            'data' => $return
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function get_ost($html = "")
    {
        $html = str_get_html($this->type['update_ost']['body']);
        $return = array();
        foreach ($html->find('div.col-6') as $col) {
            $crd_img = $col->find('div.Card__image', 0)->innertext;
            preg_match_all('#<picture>(.*?)</picture>#', $crd_img, $matches);
            preg_match_all('#<source type="image/webp" srcset="(.*?)"#', $matches[1][0], $img);
            $crd_cpt = $col->find('div.Card__caption', 0)->innertext;
            preg_match_all('/<a[^>]*href="(.*?)"[^>]*>(.*?)<\/a>/i', $crd_cpt, $anchor);
            preg_match_all('#<small>(.*?)</small>#', $crd_cpt, $time);
            $times = trim(strip_tags($time[1][0]));
            $url = $anchor[1][0];
            $title = $anchor[2][0];
            $img_url = str_replace('_SM', '', $img[1][0]);
            $array = array(
                'title' => $title,
                'update_time' => $times,
                'img_url' => $img_url,
                'post_url' => $url
            );
            $return[] = $array;
        }
        echo json_encode(array(
            'section' => 'Anime OST',
            'data' => $return
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function get_update_movie($html = '')
    {
        $html = str_get_html($this->type['update_movie']['body']);
        $return = array();
        foreach ($html->find('div.Sidebar__card ul') as $body) {
            foreach ($body->find('li') as $anchor) {
                foreach ($anchor->find('a') as $href) {

                    foreach ($href->find('img') as $img) {
                        $images = $img->src;
                    }
                    $small = $href->find('small', 0)->innertext;
                    $array = array(
                        'title' => $href->title,
                        'update_time' => trim(strip_tags($small)),
                        'img_url' => $images,
                        'post_url' => $href->href
                    );
                    $return[] = $array;
                }
            }
        }
        echo json_encode(array(
            'section' => 'Anime OST',
            'data' => $return
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function get_ongoing_anime()
    {
        $html = str_get_html($this->type['ongoing_anime']['body']);
        $return = array();
        foreach ($html->find('div.Sidebar__card ul') as $body) {
            foreach ($body->find('li') as $anchor) {
                $episode = $anchor->find('small', 1)->innertext;
                foreach ($anchor->find('a.Sidebar__card-title') as $href) {
                    foreach ($href->find('img') as $img) {
                        $images = $img->src;
                    }
                    $array = array(
                        'title' => $href->title,
                        'episode' => trim(strip_tags($episode)),
                        'post_url' => $href->href
                    );
                    $return[] = $array;
                }
            }
        }
        echo json_encode(array(
            'section' => 'Anime Ongoing',
            'data' => $return
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function get_season()
    {
        $html = str_get_html($this->type['season']['body']);
        $return = array();
        foreach ($html->find('div.Sidebar__season ul') as $body) {
            foreach ($body->find('li') as $list) {
                foreach ($list->find('a') as $anchor) {
                    $span = $anchor->find('span', 0)->innertext;
                    $title = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $anchor->innertext);
                    $array = array(
                        'title' => $title,
                        'total' => $span,
                        'url' => $anchor->href
                    );
                    $return[] = $array;
                }
            }
        }
        echo json_encode(array(
            'section' => 'Season',
            'data' => $return
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}

class DoronimeDL
{
    public $url, $html;
    public function __construct($url = '')
    {
        $this->url = $url;
        $this->html = file_get_contents($this->url);
    }

    public function download()
    {
        $html = str_get_html($this->html);
        $post_get = array(
            'post_title' => $html->find('title', 0)->innertext,
            'content_title' => $html->find('h5.Content__title', 0)->innertext,
            'data' => array()
        );
        foreach ($html->find('div.Content__link') as $link) {
            preg_match_all('#<div class="Download__title col-12">(.*?)</div>#', $link->innertext, $matches);
            $container_push = [];
            foreach ($link->find('div.Download__container') as $container) {
                $group_push = [];
                foreach ($container->find('div.Download__group') as $group) {
                    $resolution = $group->find('div.Download__group-title', 0)->innertext;
                    $href = [];
                    foreach ($group->find('div.Download__link span a') as $url) {
                        $uplo = $url->find('span[class="d-none d-md-block"]', 0)->innertext;
                        $target = $url->href;
                        $query_str = parse_url($target, PHP_URL_QUERY);
                        parse_str($query_str, $query_params);
                        $upload = array(
                            'uploader' => $uplo,
                            'url' => "https://api.rin666.me/v1/doronime/egao.php?id=" . trim($query_params['id'])
                        );
                        $href[] = $upload;
                    }
                    $group_push[] = array(
                        'resolution' => $resolution,
                        'data' => $href
                    );
                }
                $container_push[] = $group_push;
            }
            $combine = array_combine($matches[1], $container_push);
            $new = [];
            foreach ($combine as $key => $val) {
                $new[] = [
                    "type" => $key,
                    "data" => $val
                ];
            }
            $post_get['data'] = $new;
        }
        echo json_encode($post_get, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
