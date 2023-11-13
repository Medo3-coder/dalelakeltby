<?php

namespace App\Http\Livewire\Lab\Auth;

use App\Models\LabCategory;
use App\Models\TargetBodyArea;
use Livewire\Component;

class SelectCategory extends Component {
    public $bodyAreas;
    public $categories;
    public $category_ids        = [];

    public $selectedCategories     = [];
    public $selectedTargetedBodies = [];

    public $categoriesCounters = [];

    public function mount() {
        $this->categories = LabCategory::with('children')->where('parent_id', null)->get();
        $this->bodyAreas  = TargetBodyArea::get();

        foreach ($this->categories as $index => $cat) {
            $this->categoriesCounters[$index] = [0];
        }
    }

    public function addCategoryType($key) {
        $this->categoriesCounters[$key][] = count($this->categoriesCounters[$key]);
    }

    public function removeCategoryType($key, $index) {
        $arrayIndex = array_search($index, $this->categoriesCounters[$key]);
        if ($arrayIndex !== false) {
            unset($this->categoriesCounters[$key][$arrayIndex]);
        }
    }

    public function updatedSelecteLabCategories() {
        foreach ($this->selecteLabCategories as $cat) {
            $this->selectedTargetedBodies[$cat] = [];
        }
        foreach ($this->categories as $cat) {
            if (!in_array($cat->id, $this->selecteLabCategories)) {
                unset($this->selectedCategories[$cat->id]);
            }
        }
    }

    public function render() {
        return view('livewire.lab.auth.select-category');
    }
}
