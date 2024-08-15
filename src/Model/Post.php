<?php
namespace App\Model;
use App\Helpers\Text;
use \DateTime;

class Post {

	private $id;
	private $slug;
	private $name;
	private $content;
	private $created_at;
	private $categories;

	public function getName(): ?string {
		return $this->name;
	}
	public function setName(string $new_name): self {
		$this->name= $new_name;
		return $this;
	}

	public function getContent(): ?string{
		return $this->content;
	}
	public function setContent(string $new_content): self{
		$this->content= $new_content;
		return $this;
	}

	/**
	 * @return Category[]
	 */
	public function getCategories(): ?array {
		return $this->categories;
	}

	public function addCategory(Category $category): void {
		$this->categories[]= $category;
		$category->setPost($this);
	}

	public function getCreatedAt(): DateTime {
		return new DateTime($this->created_at);
	}

	public function getExcerpt (): ?string {
		if ($this->content=== null) {
			return null;
		} else {
			return nl2br(htmlentities(Text::excerpt($this->content, 60)));
		}
	}

	public function getFormattedContent(): ?string {
		return nl2br(htmlentities($this->content));
	}

	public function getSlug(): ?string {
		return $this->slug;
	}

	public function getID(): ?int {
		return $this->id;
	}
}