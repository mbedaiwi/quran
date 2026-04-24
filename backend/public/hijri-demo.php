<?php

declare(strict_types=1);
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hijri Date API Demo</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 820px; margin: 2rem auto; padding: 0 1rem; }
        label, input, select, button { font-size: 1rem; }
        .row { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1rem; }
        input, select { padding: 0.45rem; }
        button { padding: 0.5rem 1rem; }
        pre { background: #0f172a; color: #e2e8f0; padding: 1rem; border-radius: 8px; overflow: auto; }
    </style>
</head>
<body>
<h1>Hijri API Demo (ihijri-style)</h1>
<p>Use this to test <code>/hijri.php</code> with locale, timezone, and moon-sighting adjustment.</p>

<div class="row">
    <label for="tz">Timezone</label>
    <input id="tz" value="UTC" />

    <label for="locale">Locale</label>
    <input id="locale" value="en_US" />

    <label for="adjust">Adjust days</label>
    <select id="adjust">
        <option value="-2">-2</option>
        <option value="-1">-1</option>
        <option value="0" selected>0</option>
        <option value="1">1</option>
        <option value="2">2</option>
    </select>

    <button id="run">Convert</button>
</div>

<pre id="output">Click Convert</pre>

<script>
const output = document.getElementById('output');

document.getElementById('run').addEventListener('click', async () => {
  const tz = encodeURIComponent(document.getElementById('tz').value || 'UTC');
  const locale = encodeURIComponent(document.getElementById('locale').value || 'en_US');
  const adjust = encodeURIComponent(document.getElementById('adjust').value || '0');

  const response = await fetch(`/hijri.php?tz=${tz}&locale=${locale}&adjust_days=${adjust}`);
  const json = await response.json();
  output.textContent = JSON.stringify(json, null, 2);
});
</script>
</body>
</html>
