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

	public function setPost(Post $post): void{
		$this->post= $post;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function getSlug(): ?string {
		return $this->slug;
	}

	public function getPostId(): ?int {
		return $this->post_id;
	}
}