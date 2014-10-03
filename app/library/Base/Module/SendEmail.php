<?php
namespace Base\Module;

use Base\Exception;
use Base\Exception\RequestException;

class SendEmail {
    /**
     * Update email queue
     * @param array $dataMail (email_from, email_to, email_subject, email_body)
     * @param array $attachmentPath (filename => file_path)
     * @param int $priority
     */
    public function send($dataMail = array(), $attachmentPath = array(), $priority = 5)
    {
        if (isset($dataMail['reference']) && is_array($dataMail['reference'])) {
            $references = implode(' ', $dataMail['reference']);
            $dataMail['reference'] = $references;
        }
        $dataMail['priority'] = $priority;

        /**
         * Add email queue
         * @var array
         */
        $emailQueue = new \EmailQueue();

        if ($emailQueue->save($dataMail)) {
            /**
             * Update attachments for email queue if has
             */
            if (count($attachmentPath) > 0) {
                $attachments = $this->_getAttachments($attachmentPath);
                foreach ($attachments as $attachment) {
                    $dataAttachment = array(
                        'queue_id'     => $emailQueue->id,
                        'file_content' => $attachment['fileContent'],
                        'filename'     => $attachment['filename'],
                    );

                    $emailQueueAttachment = new \EmailQueueAttachment();
                    $emailQueueAttachment->save($dataAttachment);
                }
            }

//            $this->_runCronSendEmail();
            return true;
        } else {
            die(current($emailQueue->getMessages()));
        }

        return false;
    }

    /**
     * Add attachments
     * @param array $attachmentPath
     * @return array $attachments
     */
    private function _getAttachments($attachmentPath) {
        /**
         * Add attachment
         */
        $attachments = array();
        if (count($attachmentPath) > 0) {
            $attchementCount = 0;
            foreach ($attachmentPath as $filename => $filePath) {

                /**
                 * If file path is data of file, we don't need to use file_get_contents
                 * Just use it to create attachments
                 */
                if (file_exists($filePath)) {
                    $attachment = file_get_contents($filePath);
                } else {
                    $attachment = $filePath;
                }

                $attachments[$attchementCount]['fileContent'] = $attachment;
                $attachments[$attchementCount]['filename']    = $filename;

                $attchementCount++;
            }
        }

        return $attachments;
    }
}