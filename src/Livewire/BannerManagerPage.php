<?php

namespace Kenepa\Banner\Livewire;

use BladeUI\Icons\IconsManifest;
use Filament\Actions\Action;
use Filament\Facades\Filament;
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
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Str;
use Kenepa\Banner\Banner;
use Kenepa\Banner\Contracts\BannerStorage;
use Kenepa\Banner\Facades\BannerManager;
use Kenepa\Banner\ValueObjects\BannerData;

class BannerManagerPage extends Page
{
    public ?array $data = [];

    /**
     * @var BannerContainer[]
     */
    public $banners = [];

    public ?Banner $selectedBanner = null;

    protected static string $view = 'banner::pages.banner-manager';

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $slug = 'banner-manager';

    protected static ?string $title = 'Banner Manager';

    protected ?string $subheading = 'Manage your banners';

    public function mount(): void
    {

        $this->getIcons();
        $this->getScopes();

        $this->form->fill();

        $this->getBanners();
    }

    public function createNewBannerAction()
    {
        return Action::make('createNewBanner')
            ->label('Create')
            ->form($this->getSchema())
            ->icon('heroicon-m-plus')
            ->closeModalByClickingAway(false)
            ->action(fn (array $data) => $this->createBanner($data))
            ->slideOver();
    }

    public function deleteBannerAction()
    {
        return Action::make('deleteBanner')
            ->action(function () {
                BannerManager::delete($this->selectedBanner->id);

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

        BannerManager::update(BannerData::fromArray($updatedBannerData));

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

                            Select::make('render_location')
                                ->searchable()
                                ->required()
                                ->hintAction(\Filament\Forms\Components\Actions\Action::make('help')
                                    ->icon('heroicon-o-question-mark-circle')
                                    ->extraAttributes(['class' => 'text-gray-500'])
                                    ->label('')
                                    ->tooltip('With render location, you can select where a banner is rendered on the page. In combination with scopes, this becomes a powerful tool to manage where and when your banners are displayed. You can choose to render banners in the header, sidebar, or other strategic locations to maximize their visibility and impact.'))
                                ->options([
                                    'Panel' => [
                                        PanelsRenderHook::BODY_START => 'Header',
                                        PanelsRenderHook::PAGE_START => 'Start of page',
                                        PanelsRenderHook::PAGE_END => 'End of page',
                                    ],
                                    'Authentication' => [
                                        PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE => 'Before login Form',
                                        PanelsRenderHook::AUTH_LOGIN_FORM_AFTER => 'After login form',
                                        PanelsRenderHook::AUTH_PASSWORD_RESET_RESET_FORM_BEFORE => 'Before reset password form',
                                        PanelsRenderHook::AUTH_PASSWORD_RESET_RESET_FORM_AFTER => 'After reset password form',
                                        PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE => 'Before register form',
                                        PanelsRenderHook::AUTH_REGISTER_FORM_AFTER => 'After register form',
                                    ],
                                    'Global search' => [
                                        PanelsRenderHook::GLOBAL_SEARCH_BEFORE => 'Before global search',
                                        PanelsRenderHook::GLOBAL_SEARCH_AFTER => 'After global search',
                                    ],
                                    'Page Widgets' => [
                                        PanelsRenderHook::PAGE_HEADER_WIDGETS_BEFORE => 'Before header widgets',
                                        PanelsRenderHook::PAGE_HEADER_WIDGETS_AFTER => 'After header widgets',
                                        PanelsRenderHook::PAGE_FOOTER_WIDGETS_BEFORE => 'Before footer widgets',
                                        PanelsRenderHook::PAGE_FOOTER_WIDGETS_AFTER => 'After footer widgets',
                                    ],
                                    'Sidebar' => [
                                        PanelsRenderHook::SIDEBAR_NAV_START => 'Before sidebar navigation',
                                        PanelsRenderHook::SIDEBAR_NAV_END => 'After sidebar navigation',
                                    ],
                                    'Resource Table' => [
                                        PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE => 'Before resource table',
                                        PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_AFTER => 'After resource table',
                                    ],
                                ]),

                            Select::make('scope')
                                ->hintAction(\Filament\Forms\Components\Actions\Action::make('help')
                                    ->icon('heroicon-o-question-mark-circle')
                                    ->extraAttributes(['class' => 'text-gray-500'])
                                    ->label('')
                                    ->tooltip('With scoping, you can control where your banner is displayed. You can target your banner to specific pages or entire resources, ensuring it is shown to the right audience at the right time.'))
                                ->searchable()
                                ->multiple()
                                ->options(fn () => $this->getScopes()),

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
                                    TextInput::make('icon')
                                        ->default('heroicon-m-megaphone')
                                        ->placeholder('heroicon-m-wrench'),
                                    //                                    Select::make('icon')
                                    //                                        ->searchable()
                                    //                                        ->options(fn() => $this->getIcons())
                                    //                                    ->columnSpan(2),
                                    ColorPicker::make('icon_color')
                                        ->label('Color')
                                        ->default('#fafafa')
                                        ->required(),
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

                            Fieldset::make('Padding')
                                ->schema([
                                    TextInput::make('padding_top')
                                        ->label('Top')
                                        ->prefixIcon('heroicon-m-arrow-up')
                                        ->default(10)
                                        ->integer(),
                                    TextInput::make('padding_right')
                                        ->label('Right')
                                        ->prefixIcon('heroicon-m-arrow-right')
                                        ->default(10)
                                        ->integer(),
                                    TextInput::make('padding_bottom')
                                        ->label('Bottom')
                                        ->prefixIcon('heroicon-m-arrow-down')
                                        ->default(10)
                                        ->integer(),
                                    TextInput::make('padding_left')
                                        ->label('Left')
                                        ->prefixIcon('heroicon-m-arrow-left')
                                        ->default(10)
                                        ->integer(),
                                ])
                                ->columns(4),
                        ]),
                    Tabs\Tab::make('Scheduling')
                        ->icon('heroicon-m-clock')
                        ->schema([
                            DateTimePicker::make('start_time')
                                ->hintAction(
                                    \Filament\Forms\Components\Actions\Action::make('reset')
                                        ->icon('heroicon-m-arrow-uturn-left')
                                        ->action(function (Set $set, $state) {
                                            $set('start_time', null);
                                        })
                                ),
                            DateTimePicker::make('end_time')
                                ->hintAction(
                                    \Filament\Forms\Components\Actions\Action::make('reset')
                                        ->icon('heroicon-m-arrow-uturn-left')
                                        ->action(function (Set $set, $state) {
                                            $set('start_time', null);
                                        })
                                ),
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

    private function getIcons(): array
    {
        // TODO: Add alternative option to use a free input form instead of select
        //TODO: able to configure the sets
        $heroicons = app(IconsManifest::class)->getManifest(['heroicons'])['heroicons'];

        return array_values($heroicons)[0];
    }

    private function getScopes(): array
    {
        /**
         * @var resource[] $resources
         */
        $resources = $this->getPanelResources();
        $scopes = [];

        foreach ($resources as $resource) {
            $resourceSlug = $resource::getSlug();
            $resourcePath = str($resource)->value();
            $scopes[$resourceSlug] = [$resourcePath => Str::afterLast(str($resourcePath), '\\')];
            $scopes[$resourceSlug] = array_merge($scopes[$resourceSlug], $this->getPagesForResource($resource));
        }

        return $scopes;
    }

    /**
     * @param  resource  $resourceClass
     * @return string[]
     */
    private function getPagesForResource($resourceClass): array
    {
        $pages = [];

        foreach ($resourceClass::getPages() as $page) {
            $pageClass = $page->getPage();
            $pageName = Str::afterLast($pageClass, '\\');
            $pages[$pageClass] = $pageName;
        }

        return $pages;
    }

    private function getPanelResources(): array
    {
        return array_values(Filament::getCurrentPanel()->getResources());
    }

    public function disableAllBanners()
    {
        BannerManager::disableAllBanners();
        $this->getBanners();

        Notification::make()
            ->title('Disabled all banners')
            ->success()
            ->send();
    }

    public function enableAllBanners()
    {
        BannerManager::enableAllBanners();
        $this->getBanners();

        Notification::make()
            ->title('Enabled all banners')
            ->success()
            ->send();
    }
}
