<?php

namespace App\Filament\Pages;

use App\Models\QrisSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageQrisSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationGroup = 'Manajemen';

    protected static ?string $navigationLabel = 'QRIS';

    protected static ?string $title = 'Pengaturan QRIS';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.manage-qris-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $setting = QrisSetting::instance();

        $this->form->fill([
            'image_path' => $setting->image_path,
            'label' => $setting->label,
            'is_active' => $setting->is_active,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label('Gambar QRIS')
                    ->image()
                    ->directory('qris')
                    ->visibility('public')
                    ->required()
                    ->helperText('Hanya satu QRIS untuk seluruh toko. Unggah gambar kode QR yang akan ditampilkan ke pembeli saat checkout.'),
                Forms\Components\TextInput::make('label')
                    ->label('Keterangan (opsional)')
                    ->maxLength(255)
                    ->placeholder('Misalnya: QRIS Toko Sinar Mentari'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Nonaktifkan jika QRIS sementara tidak tersedia di checkout.'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        QrisSetting::instance()->update($data);

        Notification::make()
            ->title('QRIS disimpan')
            ->success()
            ->send();
    }
}
