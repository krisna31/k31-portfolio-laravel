<?php

namespace App\Providers;

use DutchCodingCompany\FilamentSocialite\Facades\FilamentSocialite as FilamentSocialiteFacade;
use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Support\Assets\Js;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentSocialiteFacade::setCreateUserCallback(fn(SocialiteUserContract $oauthUser, FilamentSocialite $socialite) => $socialite->getUserModelClass()::create([
            'name' => $oauthUser->getName(),
            'email' => $oauthUser->getEmail(),
            'email_verified_at' => now(),
            'avatar' => $oauthUser->getAvatar(),
            'provider' => "Google",
            'created_by' => 'Google',
        ]));

        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->modalHeading('Available Panels')
                // ->visible(fn(): bool => auth()->user()->hasRole([
                //     'super_admin',
                //     'admin',
                // ]))
                ->visible(fn(): bool => false)
                ->modalWidth('md')
                // ->slideOver()
                ->icons([
                    'admin' => 'heroicon-o-check-badge',
                    'app' => 'heroicon-o-square-2-stack',
                ])
                ->iconSize(16)
                ->labels([
                    'admin' => 'Admin',
                    'app' => 'K31 App',
                ])
                ->simple();
            ;
        });


        FilamentAsset::register([
            Js::make('custom-lat-long-attende-js', __DIR__ . '/../../resources/js/get-location.js')
            // ->loadedOnRequest()
            ,
        ]);

        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');

        // JsonResource::withoutWrapping();
    }
}
