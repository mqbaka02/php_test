<?php
namespace App;
use \App\Connection;

class PaginatedQuery {

    private $query;
    private $queryCount;
    private $pdo;
    private $perPage;
    private $count;
    private $items;

    public function __construct(
        string $query,
        string $queryCount,
        ?\PDO $pdo= null,
        ?int $perPage= 12
    ){
        $this->query= $query;
        $this->queryCount= $queryCount;
        $this->pdo= $pdo?: Connection::getPDO();
        $this->perPage= $perPage;
    }

    private function getPages(){
        if($this->count=== null){
            $count= (int)$this->pdo
                    ->query($this->queryCount)
                    ->fetch(\PDO::FETCH_NUM)[0];
            $this->count= $count;
        }
        // dd(($this->count));
        return ceil($this->count / $this->perPage);
    }

    public function getItems(string $classMapping): array{
        if($this->items=== null){
            dump('Called again?');
            $cPage= $this->getCurrentPage();
            // $cPage= 0;
            $pages= $this->getPages();
            // dd($pages);
            if($cPage > $pages) {
                throw new \Exception("Wrong page number");
            }
            $offset= $this->perPage * ($cPage - 1);
            $this->items= $this->pdo->query(
                $this->query .
                " LIMIT " . $this->perPage . " OFFSET " . $offset
            )->fetchAll(\PDO::FETCH_CLASS, $classMapping);
        }
        return $this->items;
    }

    public function previousLink(string $link): ?string{
        $currentPage= $this->getCurrentPage();
        if($currentPage<= 1) return null;
        // if($currentPage> 2) $link .= "?page" . ($currentPage - 1);
        $plink= $link . "?page=" . ($currentPage - 1);

        return <<<HTML
            <a href="{$plink}" class= 'btn prm' >&laquo; Previous page</a>";
HTML;
    }

    public function nextLink(string $link): ?string{
        $pages= $this->getPages();
        $currentPage= $this->getCurrentPage();
        if($currentPage>= $pages) return null;
        // if($currentPage> 2) $link .= "?page" . ($currentPage - 1);
        $plink= $link . "?page=" . ($currentPage + 1);

        return <<<HTML
            <a href="{$plink}" class= 'btn prm' id="nxt-pg">Next page &raquo;</a>";
HTML;
    }

    public function getCurrentPage(): int{
        return URL::getPositiveInt('page', 1);
    }
}