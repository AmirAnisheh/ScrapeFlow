<?php


namespace AmirAnisheh\ScrapeFlow;

class HtmlParser
{
    protected \DOMDocument $dom;
    protected \DOMXPath $xpath;
    protected array $currentNodes = [];
    protected ?string $html = null;

    public function __construct()
    {
        $this->dom = new \DOMDocument();
    }

    /**
     * Load HTML from a URL
     */
    public function url(string $url): self
    {
        $this->html = @file_get_contents($url);
        return $this->loadHtml($this->html);
    }

    /**
     * Load HTML from a string
     */
    public function loadHtml(string $html): self
    {
        $this->html = $html;
        @$this->dom->loadHTML($html);
        $this->xpath = new \DOMXPath($this->dom);
        $this->currentNodes = [$this->dom]; // start with full document
        return $this;
    }

    /**
     * Select nodes by tag name
     */
    public function getByTag(string $tag): self
    {
        $nodes = [];
        foreach ($this->currentNodes as $parent) {
            $list = $parent->getElementsByTagName($tag);
            foreach ($list as $node) {
                $nodes[] = $node;
            }
        }
        $this->currentNodes = $nodes;
        return $this;
    }

    /**
     * Select nodes by class name
     */
    public function getByClass(string $class): self
    {
        $nodes = [];
        foreach ($this->currentNodes as $parent) {
            $list = $this->xpath->query(".//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]", $parent);
            foreach ($list as $node) {
                $nodes[] = $node;
            }
        }
        $this->currentNodes = $nodes;
        return $this;
    }

    /**
     * Select node by id
     */
    public function getById(string $id): self
    {
        $nodes = [];
        foreach ($this->currentNodes as $parent) {
            $list = $this->xpath->query(".//*[@id='$id']", $parent);
            foreach ($list as $node) {
                $nodes[] = $node;
            }
        }
        $this->currentNodes = $nodes;
        return $this;
    }

    /**
     * Select nodes by attribute
     */
    public function getByAttribute(string $attr, string $value): self
    {
        $nodes = [];
        foreach ($this->currentNodes as $parent) {
            $list = $this->xpath->query(".//*[@$attr='$value']", $parent);
            foreach ($list as $node) {
                $nodes[] = $node;
            }
        }
        $this->currentNodes = $nodes;
        return $this;
    }

    /**
     * Get text content of first node
     */
    public function text(): ?string
    {
        return isset($this->currentNodes[0]) ? $this->currentNodes[0]->textContent : null;
    }

    /**
     * Get array of text contents
     */
    public function texts(): array
    {
        $result = [];
        foreach ($this->currentNodes as $node) {
            $result[] = $node->textContent;
        }
        return $result;
    }

    /**
     * Get HTML of first node
     */
    public function html(): ?string
    {
        return isset($this->currentNodes[0]) ? $this->dom->saveHTML($this->currentNodes[0]) : null;
    }

    /**
     * Get HTML array of all nodes
     */
    public function allHtml(): array
    {
        $result = [];
        foreach ($this->currentNodes as $node) {
            $result[] = $this->dom->saveHTML($node);
        }
        return $result;
    }
}
