<?php

namespace App\Traits;
use ORM\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping as ORM;;

trait DateTrait {

    // #[HasLifecycleCallbacks]

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;
    
    
    #[ORM\PrePersist] 
    public function setCreatedAtValue(){
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }
    #[ORM\PreUpdate] 
    public function setUpdatedAtValue(){
        $this->updatedAt = new \DateTimeImmutable();
    }
    
    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }
    
    
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
    
}

