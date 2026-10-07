{{--
  Structured Data toàn site (schema.org): WebSite + Organization.
  Dữ liệu lấy 100% từ config/seo.php — KHÔNG hardcode tại đây.
  Schema riêng của từng trang (Product, ItemList...) đẩy qua @push('jsonld').
--}}
@php
    $seoOrg  = config('seo.organization');
    $seoBase = config('seo.base_url');

    $seoAddress = function ($a) {
        return array_filter([
            '@type'           => 'PostalAddress',
            'streetAddress'   => $a['street'] ?? null,
            'addressLocality' => $a['locality'] ?? null,
            'postalCode'      => $a['postal_code'] ?? null,
            'addressCountry'  => $a['country'] ?? null,
        ]);
    };

    $seoWebsite = [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        '@id'      => $seoBase . '/#website',
        'name'     => $seoOrg['legal_name'],
        'url'      => $seoBase,
        'inLanguage' => 'vi-VN',
        'publisher'  => ['@id' => $seoBase . '/#organization'],
    ];

    $seoOrganization = [
        '@context'      => 'https://schema.org',
        '@type'         => 'Organization',
        '@id'           => $seoBase . '/#organization',
        'name'          => $seoOrg['legal_name'],
        'alternateName' => config('seo.brand'),
        'url'           => $seoBase,
        'logo'          => seo_abs($seoOrg['logo']),
        'image'         => seo_abs($seoOrg['logo']),
        'description'   => config('seo.default_description'),
        'foundingDate'  => $seoOrg['founding_date'],
        'email'         => $seoOrg['email'],
        'address'       => $seoAddress($seoOrg['address']),
        'sameAs'        => $seoOrg['same_as'],
    ];

    $seoOrganization['contactPoint'] = array_map(function ($phone) {
        return [
            '@type'             => 'ContactPoint',
            'telephone'         => $phone,
            'contactType'       => 'customer service',
            'areaServed'        => 'VN',
            'availableLanguage' => ['Vietnamese'],
        ];
    }, $seoOrg['phones']);

    $seoOrganization['location'] = array_map(function ($place) use ($seoAddress) {
        return [
            '@type'   => 'Place',
            'name'    => $place['name'],
            'address' => $seoAddress($place),
        ];
    }, $seoOrg['locations']);

    $seoJsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG;
@endphp
<script type="application/ld+json">{!! json_encode($seoWebsite, $seoJsonFlags) !!}</script>
<script type="application/ld+json">{!! json_encode($seoOrganization, $seoJsonFlags) !!}</script>
