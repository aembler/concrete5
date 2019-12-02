<?php
namespace Concrete\Core\Entity\Board;

use Concrete\Core\Entity\Board\DataSource\ConfiguredDataSource;
use Concrete\Core\Entity\Site\Site;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Boards")
 */
class Board
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Concrete\Core\Entity\Site\Site")
     * @ORM\JoinColumn(name="siteID", referencedColumnName="siteID")
     */
    protected $site;
    
    /**
     * @ORM\Id @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $boardID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $boardName;

    /**
     * @ORM\OneToMany(targetEntity="Concrete\Core\Entity\Board\DataSource\ConfiguredDataSource", cascade={"remove"}, mappedBy="board")
     */
    protected $data_sources;

    /**
     * @ORM\OneToMany(targetEntity="Item", cascade={"remove"}, mappedBy="board", fetch="EXTRA_LAZY")
     */
    protected $items;

    /**
     * @ORM\OneToMany(targetEntity="Instance", cascade={"remove"}, mappedBy="board", fetch="EXTRA_LAZY")
     */
    protected $instances;

    /**
     * @ORM\OneToMany(targetEntity="ItemBatch", cascade={"remove"}, mappedBy="board", fetch="EXTRA_LAZY")
     */
    protected $batches;

    /**
     * @ORM\ManyToOne(targetEntity="Template")
     */
    protected $template;

    /**
     * @ORM\Column(type="integer", options={"unsigned": true}, nullable=true)
     */
    protected $dateLastRefreshed;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hasCustomWeightingRules = false;

    public function __construct()
    {
        $this->data_sources = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->batches = new ArrayCollection();
        $this->instances = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getSite(): ?Site
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site): void
    {
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getBoardID()
    {
        return $this->boardID;
    }
    
    /**
     * @return mixed
     */
    public function getBoardName()
    {
        return $this->boardName;
    }

    /**
     * @param mixed $boardName
     */
    public function setBoardName($boardName): void
    {
        $this->boardName = $boardName;
    }

    /**
     * @return ConfiguredDataSource[]
     */
    public function getDataSources()
    {
        return $this->data_sources;
    }

    /**
     * @param mixed $data_sources
     */
    public function setDataSources($data_sources): void
    {
        $this->data_sources = $data_sources;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getBatches()
    {
        return $this->batches;
    }

    /**
     * @param mixed $batches
     */
    public function setBatches($batches): void
    {
        $this->batches = $batches;
    }

    /**
     * @return mixed
     */
    public function getDateLastRefreshed()
    {
        return $this->dateLastRefreshed;
    }

    /**
     * @param mixed $dateLastRefreshed
     */
    public function setDateLastRefreshed($dateLastRefreshed): void
    {
        $this->dateLastRefreshed = $dateLastRefreshed;
    }

    /**
     * @return mixed
     */
    public function getTemplate() : Template
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template): void
    {
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function hasCustomWeightingRules()
    {
        return $this->hasCustomWeightingRules;
    }

    /**
     * @param mixed $hasCustomWeightingRules
     */
    public function setHasCustomWeightingRules($hasCustomWeightingRules): void
    {
        $this->hasCustomWeightingRules = $hasCustomWeightingRules;
    }

    /**
     * @return mixed
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * @param mixed $instances
     */
    public function setInstances($instances): void
    {
        $this->instances = $instances;
    }
    
    
    
    
    


}