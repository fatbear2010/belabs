<div class="row" style="width:100%">
<div class="col-lg-2 text-center">
  <img alt="" style="max-width:100%; max-height:150px;" onerror="this.onerror=null; this.src='{{ asset('argon') }}/img/BL3.png'" src="https://my.ubaya.ac.id/img/krywn/{{auth()->user()->nrpnpk}}_m.jpg">
</div>
<div class="col-lg-10 md-12 text-left">
<div class="table-responsive"> 
  <table class="table wrap">
    <tr><td>NRP/NPK</td><td><b>{{ $dosen[0]->nrpnpk }}</b></td></tr>
    <tr><td>Nama Lengkap</td><td><b>{{ $dosen[0]->nama }}</b></td></tr>
    <tr><td>Fakultas</td><td><b>{{ $dosen[0]->fakultas }}</b></td></tr>
  </table>
</div>
</div>
</div>