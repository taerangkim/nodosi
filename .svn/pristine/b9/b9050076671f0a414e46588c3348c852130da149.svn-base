<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class review extends Controller
{
    private $blade;
    private $views;
    private $compiledFolder;
    private $dao;
    private $util;
    public $urlparams;
    private $CommModel;
    public $pageingSize;
    private $allowed_Ext;


    public function __construct() {

        $this->views = $_SERVER['DOCUMENT_ROOT'] . '/application/views';
        $this->compiledFolder = $_SERVER['DOCUMENT_ROOT'] . '/compiled';

        $this->blade = new BladeOne($this->views , $this->compiledFolder , BladeOne::MODE_SLOW);
        $this->dao = new \system\dao\dao();
        $this->RowsCount = 0;
        $this->pageingSize = 21;
        $conn = $this->dao->open();
        if ($conn)
        {
            //echo "Connected!<br>";
        }else
        {

        }
        $url = '';
        $this->util = new \system\util\util();
        if (isset($_GET['url'])) {
            $url = ltrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        }
        $this->urlparams = explode('/', $url);
        $this->CommModel = $this->loadModel('CommModel');
    }
    public function index()
    {
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('review.index',[

            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }

    public function reviewImgLoad()
    {
        $page = $this->util->urlParam('page','1');

        $this->dao->queryOption = [
            'col' =>
                [
                    'TB.BIdx',
                    'TB.MemIdx',
                    'TM.NickName',
                    'TB.title',
                    'TB.RegDate',
                    'TB.Content',
                    'TB.Count',
                    'ifnull ((SELECT ImageName FROM Tbl_Board_R_Img AS BRI 
                        INNER JOIN Tbl_Image AS TI ON BRI.ImgIdx = TI.ImgIdx 
                        WHERE BIdx = TB.BIdx ORDER BY TI.ImgIdx asc LIMIT 0,1  ), \'\') as ImageName',
                    'ifnull ((SELECT path FROM Tbl_Board_R_Img AS BRI 
                        INNER JOIN Tbl_Image AS TI ON BRI.ImgIdx = TI.ImgIdx
                        WHERE BIdx = TB.BIdx Order BY TI.ImgIdx asc LIMIT 0,1), \'\') as path'
                ],
            'table' => 'Tbl_Board AS TB',
            'join' => [
                'INNER JOIN Tbl_Member AS TM ON TB.MemIdx = TM.MemIdx',
            ],
            'where' =>
                [
                    'TB.ComCode' => ['=', '2002', ''],
                ],
            'order' => 'RegDate desc',
            'limit' => (($page-1) * $this->pageingSize) . ', ' .  ($this->pageingSize * $page)
        ];
        //echo $this->dao->getQuery();
        $result = $this->dao->ExecuteFill();
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
    }

    public function comment()
    {
        if (!isset($_SESSION['MemIdx'])) {
            header('Location: /login');
            exit;
        }

        $comment = $this->util->urlParam('comment', '');
        $bidx = $this->util->urlParam('bidx','');
        if($comment == '') {
            try {
                echo $this->blade->run('_templates.alertRedirect',[
                    'msg' => '댓글 내용을 적어주세요.',
                    'location' => '/review/reviewdetail?bidx='.$bidx,
                ]);
            } catch (Exception $e) {
                echo "error found" . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        } else {
            if (isset($_SESSION['MemIdx'])) {
                $this->dao->queryOption = [
                    'table' => 'Tbl_BoardReply',
                    'val' => [
                        'BIdx' => $bidx,
                        'MemIdx' => $_SESSION['MemIdx'],
                        'Contents' => $comment
                    ]
                ];
                $this->dao->ExecuteInsert();
                try {
                    echo $this->blade->run('_templates.alertRedirect', [
                        'msg' => '댓글 작성이 완료 되었습니다.',
                        'location' => '/review/reviewdetail?bidx=' . $bidx,
                    ]);
                } catch (Exception $e) {
                    echo "error found" . $e->getMessage() . "<br>" . $e->getTraceAsString();
                }
            } else {
                try {
                    echo $this->blade->run('_templates.alertRedirect', [
                        'msg' => '로그인 후 이용해주세요',
                        'location' => '/login?ret=review',
                    ]);
                } catch (Exception $e) {
                    echo "error found" . $e->getMessage() . "<br>" . $e->getTraceAsString();
                }
            }
        }
    }

    public function reviewload()
    {
        $page = $this->util->urlParam('page','1');
        $pageingSize = $this->util->urlParam('pageingSize','10');
        $this->ComCode = $this->CommModel->GetComCode();
        $this->dao->queryOption = [
            'col' =>
                [
                    'TB.BIdx',
                    'TB.MemIdx',
                    'TM.NickName',
                    'TB.title',
                    'TB.RegDate',
                    'TB.Content',
                    'TB.Count',

                    '(SELECT GROUP_CONCAT(ImageName) FROM Tbl_Board_R_Img AS BRI
                        INNER JOIN Tbl_Image AS TI ON BRI.ImgIdx = TI.ImgIdx  
                        WHERE BIdx = TB.BIdx) as ImageName',
                    '(SELECT GROUP_CONCAT(path) FROM Tbl_BoardImage AS BRI
                        INNER JOIN Tbl_Image AS TI ON BRI.ImgIdx = TI.ImgIdx
                        WHERE BIdx = TB.BIdx) as path'
                ],
            'table' => 'Tbl_Board AS TB',
            'join' => [
                'INNER JOIN Tbl_Member AS TM ON TB.MemIdx = TM.MemIdx',
            ],
            'where' =>
                [
                    'TB.ComCode' => ['=', '2002', ''],
                ],
            'order' => 'RegDate desc',
            'limit' => (($page-1) * $this->pageingSize) . ', ' .  ($this->pageingSize * $page)
        ];
        echo $this->dao->getQuery();
        $result = $this->dao->ExecuteFill();
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
    }

    public function reviewWrite()
    {
        if (!isset($_SESSION['MemIdx'])) {
            header('Location: /login');
            exit;
        }
        $title = $this->util->urlParam('Title', '');
        $count = $this->util->urlParam('Count', '');
        $content = $this->util->urlParam('Content', '');
        $reviewlistjson = $this->util->urlParam('reviewlistjson', '');

        $this->dao->queryOption = [
            'table' => 'Tbl_Board',
            'val' => [
                'ComCode' => '2002',
                'MemIdx' => $_SESSION['MemIdx'],
                'Title' => $title,
                'Count' => $count,
                'Content' => $content
            ]
        ];
        $BIdx = $this->dao->ExecuteInsetLastId();
        $imgArray = json_decode($reviewlistjson);
        foreach ($imgArray->value as $item)
        {
            $this->dao->queryOption=[
                'table' => 'Tbl_Board_R_Img',
                'val' => [
                    'BIdx' => $BIdx,
                    'ImgIdx' => $item->ImgIdx
                ]
            ];
            $this->dao->ExecuteInsert();
        }
        try {
            echo $this->blade->run('_templates.alertRedirect',[
                'msg' => '리뷰 글 작성이 완료 되었습니다.',
                'location' => '/review',
            ]);
        } catch (Exception $e) {
            echo "error found" . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function reviewUpDate()
    {
        if (!isset($_SESSION['MemIdx'])) {
            header('Location: /login');
            exit;
        }

        $title = $this->util->urlParam('Title', '');
        $count = $this->util->urlParam('Count', '');
        $content = $this->util->urlParam('Content', '');
        $bidx = $this->util->urlParam('bidx','');
        $reviewlistjson = $this->util->urlParam('reviewlistjson', '');

        $this->dao->queryOption = [
            'table' => 'Tbl_Board',
            'val' => [
                'Title' => $title,
                'Count' => $count,
                'Content' => $content,
            ],
            'where' => [
                'BIdx' => ['=',$bidx,''],
            ]
        ];
        $this->dao->ExecuteUpdate();

        $this->dao->queryOption=[
            'table' =>  'Tbl_Board_R_Img',
            'val' => [
                'IsDel' => 'Y'
            ],
            'where' =>
            [
                'Bidx' =>['=', $bidx, '']
            ]
        ];
        $this->dao->ExecuteUpdate();

        $imgArray = json_decode($reviewlistjson);
        foreach ($imgArray->value as $item)
        {
            $this->dao->queryOption=[
                'table' => 'Tbl_Board_R_Img',
                'val' => [
                    'BIdx' => $bidx,
                    'ImgIdx' => $item->ImgIdx
                ]
            ];
            $this->dao->ExecuteInsert();
        }



//        try {
//            echo $this->blade->run('_templates.alertRedirect', [
//                'msg' => '리뷰 글이 수정되었습니다.',
//                'location' => '/review/reviewdetail?bidx='.$bidx,
//            ]);
//        } catch (Exception $e) {
//            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
//        }
    }
    public function reviewDelete(){
        if (!isset($_SESSION['MemIdx'])) {
            header('Location: /login');
            exit;
        }

        $BIdx = $this->util->urlParam('revideidx', '');
        $this->dao->queryOption=[
            'table' => 'Tbl_Board',
            'where' => [
                'BIdx' => ['=', $BIdx, '']
            ]
        ];
        $this->dao->ExecuteDel();
        try {
            echo $this->blade->run('_templates.alertRedirect', [
                'msg' => '삭제되었습니다.',
                'location' => '/review',
            ]);
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }

    public  function reviewdetail()
    {
        if (!isset($_SESSION['MemIdx'])) {
            header('Location: /login');
            exit;
        }


        $bidx = $this->util->urlParam('bidx','');

        $this->dao->queryOption = [
            'col' =>
                [
                    'TB.BIdx',
                    'TB.MemIdx',
                    'TM.NickName',
                    'TB.title',
                    'TB.RegDate',
                    "Replace(TB.Content, chr(13),'<BR>') as Content",
                    'TB.Count',
                    '(SELECT GROUP_CONCAT(BIIdx) FROM Tbl_BoardImage WHERE BIdx = TB.BIdx) as BIIdx',
                    '(SELECT GROUP_CONCAT(ImageName) FROM Tbl_Board_R_Img AS BRI
                        INNER JOIN Tbl_Image AS TI ON BRI.ImgIdx = TI.ImgIdx  
                        WHERE BIdx = TB.BIdx) as ImageName',
                    '(SELECT GROUP_CONCAT(path) FROM Tbl_Board_R_Img AS BRI
                        INNER JOIN Tbl_Image AS TI ON BRI.ImgIdx = TI.ImgIdx
                        WHERE BIdx = TB.BIdx) as path',
                ],
            'table' => 'Tbl_Board AS TB',
            'join' => [
                'INNER JOIN Tbl_Member AS TM ON TB.MemIdx = TM.MemIdx',
            ],
            'where' =>
                [
                    'TB.ComCode' => ['=', '2002', 'and'],
                    'TB.BIdx' => ['=', $bidx, '']
                ],
        ];
        $result = $this->dao->ExecuteFill();
        $this->dao->queryOption = [
            'col' =>
                [
                    'TBR.MemIdx',
                    'TM.NickName',
                    'TBR.Contents',
                    'TBR.RegDate'
                ],
            'table' => 'Tbl_BoardReply as TBR',
            'join' => 'INNER JOIN Tbl_Member AS TM ON TBR.MemIdx = TM.MemIdx',
            'where' => [
                'BIdx' => ['=', $bidx, '']
            ],
        ];
        $resultReply = $this->dao->ExecuteFill();
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('review.reviewdetail',[
                'result' => $result,
                'resultReply' => $resultReply
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function compress($source, $destination, $quality)
    {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }
    public function file()
    {
        require($_SERVER['DOCUMENT_ROOT']  . '/system/util/UploadHandler.php');
        $ROOT = $_SERVER['DOCUMENT_ROOT'];
        $yy = date('Y', time());
        $mm = date('m', time());
        $dd = date('d', time());

        $upload_dir = "/public/pds/" . $yy . '/' . $mm . '/' . $dd . '/' . $_SESSION['MemIdx'];

        if (!is_dir($ROOT . $upload_dir)) {
            mkdir($ROOT . $upload_dir, 0755, true);
        }

        $upload_handler = new UploadHandler(null, true, null, $upload_dir);
    }
}