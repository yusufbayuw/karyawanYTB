<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Infak;
use App\Models\Cabang;
use App\Models\Cicilan;
use App\Models\GajiPegawai;
use App\Models\KpiDataPanitia;
use App\Models\KpiDataPrestasi;
use App\Models\KpiKejuaraan;
use App\Models\KPIKontrak;
use App\Models\Periode;
use App\Models\Pinjaman;
use App\Models\Penilaian;
use App\Models\Pengeluaran;
use App\Models\KPIPenilaian;
use App\Observers\GajiPegawaiObserver;
use App\Observers\UserObserver;
use App\Observers\KpiDataPanitiaAfterCommitObserver;
use App\Observers\KpiDataPanitiaObserver;
use App\Observers\KpiDataPrestasiObserver;
use App\Observers\KpiKejuaraanObserver;
use App\Observers\KPIKontrakObserver;
use App\Observers\PenilaianObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Observers\KPIPenilaianObserver;
use App\Observers\PenilaianAfterCommitObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Penilaian::observe(PenilaianObserver::class);
        Penilaian::observe(PenilaianAfterCommitObserver::class);
        //Periode::observe(PeriodeObserver::class);
        KPIPenilaian::observe(KPIPenilaianObserver::class);
        KPIKontrak::observe(KPIKontrakObserver::class);
        KpiDataPanitia::observe(KpiDataPanitiaObserver::class);
        KpiDataPanitia::observe(KpiDataPanitiaAfterCommitObserver::class);
        KpiKejuaraan::observe(KpiKejuaraanObserver::class);
        KpiDataPrestasi::observe(KpiDataPrestasiObserver::class);
        GajiPegawai::observe(GajiPegawaiObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
