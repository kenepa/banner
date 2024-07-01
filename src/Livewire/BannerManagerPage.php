<?php

namespace Kenepa\Banner\Livewire;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Kenepa\Banner\Facades\BannerManager;
use Kenepa\Banner\ValueObjects\BannerData;
use Kenepa\Banner\Banner;

class BannerManagerPage extends Page
{
    public ?array $data = [];

    /**
     * @var BannerContainer[]
     */
    public $banners;

    public ?Banner $selectedBanner = null;

    protected static string $view = 'banner::pages.banner-manager';

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $slug = 'banner-manager';

    protected static ?string $title = 'Banner Manager';

    protected ?string $subheading = 'Manage your banners';

    public function mount(): void
    {
        $this->banners = [];

        $this->form->fill();

        $this->getBanners();
    }

    public function createNewBannerAction()
    {
        return Action::make('createNewBanner')
            ->form($this->getSchema())
            ->icon('heroicon-m-plus')
            ->action(fn (array $data) => $this->createBanner($data))
            ->slideOver();
    }

    public function deleteBannerAction()
    {
        return Action::make('deleteBanner')
            ->action(function () {
                BannerManager::delete($this->selectedBanner->id);

                $tempBanner = $this->selectedBanner;

                $this->selectedBanner = null;
                $this->getBanners();

                Notification::make()
                    ->title('Successfully deleted banner')
                    ->icon('heroicon-m-trash')
                    ->danger()
                    ->send();

            })
            ->color('danger')
            ->icon('heroicon-m-trash')
            ->iconButton()
            ->requiresConfirmation();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getSchema())
            ->statePath('data');
    }

    public function updateBanner()
    {
        $updatedBannerData = $this->form->getState();

        BannerManager::update($updatedBannerData);

        $this->getBanners();

        Notification::make()
            ->title('Updated successfully')
            ->success()
            ->send();
    }

    public function createBanner($data)
    {
        BannerManager::store(BannerData::fromArray($data));

        Notification::make()
            ->title('Created successfully')
            ->success()
            ->send();

        $this->getBanners();
    }

    public function getBanners(): void
    {
        $this->banners = BannerManager::getAll();
    }

    public function selectBanner(string $bannerId)
    {
        // Todo reuse findBanner index here!
        $foundIndex = BannerManager::getIndex($bannerId);

        if ($foundIndex === false) {
            Notification::make()
                ->title('Failed to load banner.')
                ->danger()
                ->send();

            return;
        }

        $this->selectedBanner = $this->banners[$foundIndex];

        $this->form->fill($this->selectedBanner->toLivewire());
    }

    public function findBannerIndex(string $bannerId): int | bool
    {
        return $this->banners->search(function (array $banner) use ($bannerId) {
            return $banner['id'] === $bannerId;
        });
    }

    public function isBannerActive($bannerId)
    {

        if (is_null($this->selectedBanner)) {
            return false;
        }

        return $this->selectedBanner->id === $bannerId;
    }

    public function getSchema(): array
    {
        return [
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('General')
                        ->icon('heroicon-m-wrench')
                        ->schema([
                            Hidden::make('id')->default(fn () => uniqid()),
                            TextInput::make('name')->required(),
                            RichEditor::make('content')
                                ->required()
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'link',
                                    'strike',
                                    'underline',
                                    'undo',
                                    'codeBlock',
                                ]),
                            Fieldset::make('Options')
                                ->schema([
                                    Checkbox::make('can_be_closed_by_user')->label('Banner can be closed by user')->columnSpan('full'),
                                    Checkbox::make('can_truncate_message')->label('Truncates the content of banner')->columnSpan('full'),
                                ]),
                            Toggle::make('is_active'),
                        ]),
                    Tabs\Tab::make('Styling')
                        ->icon('heroicon-m-paint-brush')
                        ->schema([
                            ColorPicker::make('text_color')
                                ->default('#FFFFFF')
                                ->required(),

                            Fieldset::make('Icon')
                                ->schema([
                                    ColorPicker::make('icon_color')
                                        ->label('Color')
                                        ->default('#fafafa')
                                        ->required(),
                                    TextInput::make('icon')
                                        ->default('heroicon-m-megaphone')
                                        ->placeholder('heroicon-m-wrench'),
                                ])
                                ->columns(3),
                            Fieldset::make('Background')
                                ->schema([
                                    Select::make('background_type')
                                        ->label('Type')
                                        ->reactive()
                                        ->selectablePlaceholder(false)
                                        ->default('solid')
                                        ->options([
                                            'solid' => 'Solid',
                                            'gradient' => 'Gradient',
                                        ])->default('solid'),
                                    ColorPicker::make('start_color')
                                        ->default('#D97706')
                                        ->required(),
                                    ColorPicker::make('end_color')
                                        ->default('#F59E0C')
                                        ->visible(fn ($get) => $get('background_type') === 'gradient'),
                                ])
                                ->columns(3),
                        ]),
                    Tabs\Tab::make('Scheduling')
                        ->icon('heroicon-m-clock')
                        ->schema([
                            DateTimePicker::make('start_time'),
                            DateTimePicker::make('end_time'),
                        ]),
                ])->contained(false),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $activeBannerCount = BannerManager::getActiveBannerCount();
        if ($activeBannerCount > 0) {
            return (string) $activeBannerCount;
        }

        return null;
    }
}
