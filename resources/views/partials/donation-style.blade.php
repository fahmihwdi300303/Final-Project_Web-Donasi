@push('styles')
<style>
  /* --- Gaya umum form publik: kartu besar, judul tebal, spacing lega --- */
  .donation-ui .page-title{
    font-weight:800; letter-spacing:.3px; color:#0f172a; text-align:center; margin-bottom:1rem;
  }
  .donation-ui .sub-title{ color:#2563eb; text-align:center; margin-bottom:1.25rem; }

  .donation-ui .form-card, .donation-ui .info-card{
    background:#fff; border-radius:14px; box-shadow:0 10px 24px rgba(2,6,23,.06);
    border:1px solid rgba(2,6,23,.06); padding:1.25rem 1.25rem;
  }
  @media(min-width:992px){
    .donation-ui .form-card, .donation-ui .info-card{ padding:1.5rem 1.75rem; }
  }
  .donation-ui label.form-label{ font-weight:600; color:#0f172a; }
  .donation-ui .muted{ color:#64748b; }

  /* UI "Pilih Metode Pembayaran" */
  .donation-ui .method-title{ font-weight:700; margin-bottom:.75rem; }
  .donation-ui .qr-box{
    border:2px dashed rgba(37,99,235,.25); border-radius:12px; padding:1rem; text-align:center;
  }
  .donation-ui .bank-grid{ display:grid; gap:.75rem; grid-template-columns:repeat(2,1fr);}
  @media(min-width:768px){ .donation-ui .bank-grid{ grid-template-columns:repeat(3,1fr); } }

  /* Laporan publik */
  .donation-ui .report-title{ font-weight:800; letter-spacing:.3px; color:#1e293b; text-align:center; }
  .donation-ui .report-sub{ color:#2563eb; text-align:center; margin-bottom:1rem; }
</style>
@endpush
