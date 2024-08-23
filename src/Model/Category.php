<?php
namespace App\Model;

class Category {

	private $id;
	private $slug;
	private $name;
	private $post_id;
	private $post;

	public function getID(): ?int {
		return $this->id;
	}
	public function setID(int $id): self {
		$this->id= $id;
	}

	public function setPost(Post $post): void{
		$this->post= $post;
	}

	public function getName(): ?string {
		return $this->name;
	}
	public function setName(string $slug): self {
		$this->name= $name;
	}

	public function getSlug(): ?string {
		return $this->slug;
	}
	public function setSlug(string $slug): self {
		$this->slug= $slug;
	}

	public function getPostId(): ?int {
		return $this->post_id;
	}
}