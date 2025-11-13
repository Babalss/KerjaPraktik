@php
  // $selected = array id tag yang terpilih
  $selected = $selected ?? [];
@endphp

@if($tags->isEmpty())
  <p class="text-muted small mb-0">
    Belum ada tag. Tambah dulu di menu <strong>Blog Tag</strong>.
  </p>
@else
  <div class="border rounded p-2" style="max-height: 220px; overflow-y: auto;">
    @foreach($tags as $t)
      <div class="form-check">
        <input class="form-check-input"
               type="checkbox"
               name="tag_ids[]"
               value="{{ $t->id }}"
               id="tag-{{ $t->id }}"
               @checked(in_array($t->id, $selected))>
        <label class="form-check-label" for="tag-{{ $t->id }}">
          {{ $t->name }}
        </label>
      </div>
    @endforeach
  </div>
  <div class="form-text">Bisa pilih lebih dari satu tag.</div>
@endif
