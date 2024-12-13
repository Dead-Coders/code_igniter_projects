<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$subjudul?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <a href="<?=base_url()?>hasilujian" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
                <button type="button" onclick="reload_ajax()" class="btn btn-flat btn-sm bg-purple"><i class="fa fa-refresh"></i> Reload</button>
                <div class="pull-right">
                    <a target="_blank" href="<?=base_url()?>hasilujian/cetak_detail/<?=$this->uri->segment(3)?>" class="btn bg-maroon btn-flat btn-sm">
                        <i class="fa fa-download"></i> Download/Print
                    </a>
                </div>
            </div>
            <div class="col-sm-6">
                <table class="table w-100">
                    <tr>
                        <th>Exam Name</th>
                        <td><?=$ujian->nama_ujian?></td>
                    </tr>
                    <tr>
                        <th>Total Questions</th>
                        <td><?=$ujian->jumlah_soal?></td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td><?=$ujian->waktu?> Minute</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td><?=strftime('%A, %d %B %Y', strtotime($ujian->tgl_mulai))?></td>
                    </tr>
                    <tr>
                        <th>Completion Date</th>
                        <td><?=strftime('%A, %d %B %Y', strtotime($ujian->terlambat))?></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="table w-100">
                    <tr>
                        <th>Course</th>
                        <td><?=$ujian->nama_matkul?></td>
                    </tr>
                    <tr>
                        <th>Lecturer</th>
                        <td><?=$ujian->nama_dosen?></td>
                    </tr>
                    <tr>
                        <th>Lowest Score</th>
                        <td><?=$nilai->min_nilai?></td>
                    </tr>
                    <tr>
                        <th>Highest Score</th>
                        <td><?=$nilai->max_nilai?></td>
                    </tr>
                    <tr>
                        <th>Average</th>
                        <td><?=$nilai->avg_nilai?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive px-4 pb-3" style="border: 0">
        <table id="detail_hasil" class="w-100 table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Class</th>
                <th>Dept.</th>
                <th>Correct Ans.</th>
                <th>Score</th>
            </tr>        
        </thead>
        <!-- <tfoot>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Class</th>
                <th>Dept.</th>
                <th>Correct Ans.</th>
                <th>Score</th>
            </tr>
        </tfoot> -->
        </table>
    </div>
</div>

<script type="text/javascript">
    var id = '<?=$this->uri->segment(3)?>';
</script>

<script src="<?=base_url()?>assets/dist/js/app/ujian/detail_hasil.js"></script>