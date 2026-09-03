<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterConfig extends Model
{
    protected $fillable = [
        'from_name',
        'from_email',
        'reply_to',
        'show_footer',
        'footer_text',
        'unsubscribe_text',
        'footer_background',
        'footer_text_color',
        'footer_link_color',
        'show_address',
    ];

    protected $casts = [
        'show_footer'  => 'boolean',
        'show_address' => 'boolean',
    ];

    public static function instance(): static
    {
        $config = static::first();

        if (! $config) {
            $config = static::create([]);
        }

        return $config;
    }

    public function getUnsubscribeUrl(Newsletter $subscriber): string
    {
        return route('web.newsletter.unsubscribe', $subscriber->unsubscribe_token);
    }

    public function renderFooter(Newsletter $subscriber, Config $siteConfig = null): string
    {
        if (! $this->show_footer) {
            return '';
        }

        $unsubscribeUrl = $this->getUnsubscribeUrl($subscriber);
        $siteConfig = $siteConfig ?? Config::where('id', 1)->first();
        $appName = $siteConfig->app_name ?? config('app.name');
        $year = now()->year;

        $addressHtml = '';
        if ($this->show_address && $siteConfig && $siteConfig->display_address) {
            $parts = array_filter([
                $siteConfig->street,
                $siteConfig->number,
                $siteConfig->complement,
                $siteConfig->neighborhood,
                $siteConfig->city,
                $siteConfig->state,
            ]);
            if ($parts) {
                $addressHtml = '<p style="margin:0 0 6px 0;font-size:11px;color:' . e($this->footer_text_color) . ';">' . e(implode(', ', $parts)) . '</p>';
            }
        }

        return '
<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:30px;border-top:1px solid #e5e7eb;">
    <tr>
        <td style="padding:24px 20px;background:' . e($this->footer_background) . ';border-radius:8px 8px 0 0;text-align:center;">
            <p style="margin:0 0 8px 0;font-size:12px;color:' . e($this->footer_text_color) . ';">' . e($this->footer_text) . '</p>
            ' . $addressHtml . '
            <p style="margin:0 0 8px 0;font-size:12px;color:' . e($this->footer_text_color) . ';">
                <a href="' . e($unsubscribeUrl) . '" style="color:' . e($this->footer_link_color) . ';text-decoration:underline;font-weight:600;">' . e($this->unsubscribe_text) . '</a>
            </p>
            <p style="margin:0;font-size:10px;color:' . e($this->footer_text_color) . ';">&copy; ' . $year . ' ' . e($appName) . '. Todos os direitos reservados.</p>
        </td>
    </tr>
</table>';
    }
}
