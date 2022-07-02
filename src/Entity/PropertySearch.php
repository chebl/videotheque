<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class PropertySearch
{

   private $title;
   /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $category;
   
   public function getTitle(): ?string
   {
       return $this->title;
   }

   public function setTitle(string $title): self
   {
       $this->title = $title;

       return $this;
   }
   public function getCategory(): ?Category
   {
       return $this->category;
   }

   public function setCategory(?Category $category): self
   {
       $this->category = $category;

       return $this;
   }
}