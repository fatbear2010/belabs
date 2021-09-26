<div class="table-responsive" id="jadwal">
    <table class="table align-items-center">
        <thead class="thead-light">
            <tr>
                <th scope="col" class="sort" data-sort="name">Waktu</th>
                <th scope="col" >Status</th>
                <th scope="col" class="sort" data-sort="name">Waktu</th>
                <th scope="col" >Status</th>
            </tr>
        </thead>
        <tbody class="list">
          
            <?php 
            $jum = count($sesi)/2;
            if(count($sesi)%2 == 1) $jum+=1;
            for ($i=0; $i<$jum ; $i++) { 
               if($sesi[$jum]->mulai != $sesi[$i]->mulai) {?>
              <tr>
                <td>
                    {{$sesi[$i]->mulai.' - '.$sesi[$i]->selesai}}
                </td>
                <td>
                    <?php if($sesi[$i]->status == 0 ) { ?>
                      <span class="badge badge-dot mr-4">
                      <i class="bg-danger"></i>
                      <span class="status">Tidak Tersedia</span>
                    </span>
                    <?php } else if($sesi[$i]->status == 1 ) { ?>
                      <span class="badge badge-dot mr-4">
                      <i class="bg-warning"></i>
                      <span class="status">Sedang Diproses</span>
                    </span>
                  <?php } else if($sesi[$i]->status == 3 ) { ?>
                      <span class="badge badge-dot mr-4">
                      <i class="bg-primary"></i>
                      <span class="status">Dalam Perbaikan</span>
                    </span>
                    <?php } else if($sesi[$i]->status == 2 ) { ?>
                      <span class="badge badge-dot mr-4">
                      <i class="bg-success"></i>
                      <span class="status">Tersedia</span>
                    </span>
                    <?php } ?>
                </td>
                <?php 

                  if(!isset($sesi[$i+$jum])) { 
                   echo"<td></td><td></td>"; 
                 } else {
                ?>
                 <td>
                    {{$sesi[$i+$jum]->mulai.' - '.$sesi[$i+$jum]->selesai}}
                </td>
                <td>
                   <?php if($sesi[$i+$jum]->status == 0 ) { ?>
                      <span class="badge badge-dot mr-4">
                      <i class="bg-danger"></i>
                      <span class="status">Tidak Tersedia</span>
                    </span>
                    <?php } else if($sesi[$i+$jum]->status == 1 ) { ?>
                      <span class="badge badge-dot mr-4">
                      <i class="bg-warning"></i>
                      <span class="status">Sedang Diproses</span>
                    </span>
                     <?php } else if($sesi[$i]->status == 3 ) { ?>
                      <span class="badge badge-dot mr-4">
                      <i class="bg-primary"></i>
                      <span class="status">Dalam Perbaikan</span>
                    </span>
                    <?php } else if($sesi[$i+$jum]->status == 2 ) { ?>
                      <span class="badge badge-dot mr-4">
                      <i class="bg-success"></i>
                      <span class="status">Tersedia</span>
                    </span>
                    <?php } ?>
                </td>
                </tr> 
            <?php } } } ?>
            @foreach($sesi as $s)
            
                
            @endforeach
            
            </tbody>
          </table>
</div>