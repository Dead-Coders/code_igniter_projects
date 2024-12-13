<!-- Page Heading -->
<?php $page='transaction';?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaction Data</h1>
    <a href="<?php echo base_url().'admin/transaksi_add'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> New Transaction</a>
</div>
    
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Customer/Car</th>
                        <th>Borrow/Return</th>
                        <th>Price</th>
                        <th>Fine P.D</th>
                        <th>Returned</th>
                        <th>Penalty</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $no=1;
                foreach($transaksi as $t){
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d/m/Y',strtotime($t->transaksi_tgl)); ?></td>
                        <td><?php echo '<i class="fas fa-user"> </i> '.$t->kostumer_nama.'<br><hr /><i class="fas fa-car"></i> '.$t->mobil_merk ?></td>
                        <td><?php echo date('d/m/Y',strtotime($t->transaksi_tgl_pinjam)).'<br><hr />'.date('d/m/Y',strtotime($t->transaksi_tgl_kembali)); ?></td>
                        <td><?php echo 'Rs. '.number_format($t->transaksi_harga) ?></td>
                        <td><?php echo 'Rs. '.number_format($t->transaksi_denda) ?></td>
                        <td><?php echo ($t->transaksi_tgldikembalikan == '0000-00-00') ? '--' : date('d/m/Y',strtotime($t->transaksi_tgldikembalikan)); ?></td>
                        <td><?php echo 'Rs. '.number_format($t->transaksi_totaldenda) ?></td>
                        <td>
                            <?php
                            if($t->transaksi_status == 1){
                                echo '<span class="badge badge-success">Complete</span>';
                            } else {
                            ?>
                            <a class="btn btn-info btn-sm btn-block" href="<?php echo base_url().'admin/transaksi_selesai/'.$t->transaksi_id; ?>">
                                <i class="fas fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-sm btn-block" href="<?php echo base_url().'admin/transaksi_hapus/'.$t->transaksi_id; ?>">
                                <i class="fas fa-trash"></i>
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>