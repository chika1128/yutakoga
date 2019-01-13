<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8") ;


/**
 * メール送信に必要な情報を格納するDto
 * エスケープした状態のものを渡してください
 */
class MailServiceDto
{
    #region フィールド
    //toアドレス
    private $to;
    public function getTo(){
        return $this->to;
    }
    //ccアドレス
    private $cc = '';
    public function getCc(){
        return $this->cc;
    }
    //メールタイトル
    private $title = '';
    public function getTitle(){
        return $this->title;
    }
    //メール本文
    private $body = '';
    public function getBody(){
        return $this->body;
    }
    //fromアドレス
    private $from = '';
    public function getFrom(){
        return $this->from;
    }
    #endregion

    /**
     * コンストラクタで文字列を加工し、各フィールドにセット
     * @param $to toアドレス
     * @param $cc ccアドレス
     * @param $title メールタイトル
     * @param $body メール本文
     * @param $from fromアドレス
     */
    public function __construct($to, $cc, $title, $body, $from)
    {
        $this->to = $to;
        $this->cc = $cc;
        $this->title = $title;
        $this->from = $from;

        $this->body = $body;
    }




}



/**
 * メール送信処理
 */
Class MailService {

    //フィールド
    private $mSDto;
    private $header;

    /**
     * コンストラクタでDtoをフィールドにセット
     * @param $to toアドレス
     * @param $cc ccアドレス
     * @param $title メールタイトル
     * @param $body メール本文
     * @param $from fromアドレス     */
    public function __construct($to, $cc, $title, $body, $from)
    {
        $this->mSDto = new MailServiceDto($to, $cc, $title, $body, $from);
    }

    /**
     * メール送信処理
     */
    public function send()
    {

        $errMsg = "メール送信に失敗しました。申し訳ございませんがLINEなどでご連絡ください。";

        try{
            // toを作成
            $to = $this->mailAddressToString($this->mSDto->getTo());

            // FROMをヘッダー情報に追加
            $this->header .= "From: {$this->mSDto->getFrom()}\n";

            // CCが指定されている場合はヘッダー情報に追加
            if(empty($this->mSDto->getCc()))
            {
                $cc = $this->mailAddressToString($this->mSDto->getCc());
                $this->header .= "Cc: {$cc}\n";
            }

            // メール送信
            if (mb_send_mail($to, $this->mSDto->getTitle(), $this->mSDto->getBody(), $this->header)) {
                return true;
            }
            else {
                return $errMsg;
            }

        }catch(Exception $ex){
            $errMsg .= $ex.getMessage();
            return $errMsg;
        }
    }

    /**
     * 引数が配列だった場合はカンマで接続し返却する。
     * それ以外だった場合は、そのまま返却する。
     * @param $varMailAddress 配列、もしくは文字列
     */
    function mailAddressToString($varMailAddress) {
        // 配列の場合はカンマで区切って返却
        if (is_array($varMailAddress)) {
            return implode(', ', $varMailAddress);
        }
        // その他の場合はそのまま返却
        else if ($varMailAddress) {
            return $varMailAddress;
        }
    }
}



?>