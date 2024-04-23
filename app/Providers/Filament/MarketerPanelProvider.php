<?php

namespace App\Providers\Filament;

use App\Filament\Marketer\Pages\Profile;
use App\Filament\Marketer\Resources\IntroduceResource\Widgets\BlogPostsOverview;
use App\Filament\Marketer\Resources\IntroduceResource\Widgets\LastIntroduceTable;
use App\Filament\Marketer\Resources\IntroduceResource\Widgets\SendRequestButtons;
use App\Filament\Marketer\Resources\IntroduceResource\Widgets\ShortLinkButtons;
use App\Filament\Pages\LoginAdmin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class MarketerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('marketer')
            ->path('')
            ->login(LoginAdmin::class)
            ->authGuard('marketer')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Marketer/Resources'), for: 'App\\Filament\\Marketer\\Resources')
            ->discoverPages(in: app_path('Filament/Marketer/Pages'), for: 'App\\Filament\\Marketer\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Marketer/Widgets'), for: 'App\\Filament\\Marketer\\Widgets')
            ->widgets([
//                Widgets\AccountWidget::class,
//                Widgets\FilamentInfoWidget::class,
                ShortLinkButtons::class,
                SendRequestButtons::class,
                LastIntroduceTable::class
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
