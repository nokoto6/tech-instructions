<?php
    function getPagination($page, $pageCount) {
        $paginateCount = min($pageCount, 5);
        $pages = [];
        for ($i = max(1, $page - 2); $i <= min($pageCount, $page + 2); $i++) { $pages[] = $i; }
        while (count($pages) < $paginateCount) {
            if (count($pages) < $paginateCount && reset($pages) > 1) {
                array_unshift($pages, reset($pages) - 1);
            }
            if (count($pages) < $paginateCount && end($pages) < $pageCount) {
                array_push($pages, end($pages) + 1);
            }
            $pages = array_unique($pages);
            sort($pages);
        }
        return $pages;
    }
