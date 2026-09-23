<?php
/**
 * Render aksen dekoratif "kelopak" (mengambil motif bunga pada template
 * logo Mahreen Indonesia). $uid harus unik tiap pemanggilan supaya
 * gradient id di dalam SVG tidak bentrok saat dipakai berkali-kali di
 * satu halaman.
 */
function render_petal(string $uid): string
{
    return '
    <svg class="petal" viewBox="0 0 120 120" fill="none" aria-hidden="true">
      <defs>
        <linearGradient id="petalGrad' . $uid . '" x1="0" y1="0" x2="120" y2="120" gradientUnits="userSpaceOnUse">
          <stop stop-color="#FF7A52"/>
          <stop offset="1" stop-color="#E23E8C"/>
        </linearGradient>
      </defs>
      <path d="M60 8C77 24 77 46 60 60C43 46 43 24 60 8Z" fill="url(#petalGrad' . $uid . ')"/>
      <path d="M112 60C96 77 74 77 60 60C74 43 96 43 112 60Z" fill="url(#petalGrad' . $uid . ')" opacity="0.85"/>
      <path d="M60 112C43 96 43 74 60 60C77 74 77 96 60 112Z" fill="url(#petalGrad' . $uid . ')" opacity="0.7"/>
      <path d="M8 60C24 43 46 43 60 60C46 77 24 77 8 60Z" fill="url(#petalGrad' . $uid . ')" opacity="0.85"/>
      <circle cx="60" cy="60" r="7" fill="url(#petalGrad' . $uid . ')"/>
    </svg>';
}
