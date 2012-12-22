<?php

/***************************************************************************
*
*    Package  : PayPal WPS Toolkit PHP Samples
*
*    PAYPAL, INC.
*
*    WPSToolKit LICENSE
*
*    NOTICE TO USER:  PayPal, Inc. is providing the Software and Documentation
*    for use under the terms of this Agreement.  Any use, reproduction,
*    modification or distribution of the Software or Documentation, or any
*    derivatives or portions hereof, constitutes your acceptance of this
*    Agreement.
*
*    As used in this Agreement, "PayPal" means PayPal, Inc.  "Software" means
*    the software code accompanying this agreement. "Documentation" means the
*    documents, specifications and all other items accompanying this Agreement
*    other than the Software.
*
*    1.  LICENSE GRANT Subject to the terms of this Agreement, PayPal hereby
*    grants you a non-exclusive, worldwide, royalty free license to use,
*    reproduce, prepare derivative works from, publicly display, publicly
*    perform, distribute and sublicense the Software for any purpose, provided
*    the copyright notice below appears in a conspicuous location within the
*    source code of the distributed Software and this license is distributed in
*    the supporting documentation of the Software you distribute. Furthermore,
*    you must comply with all third party licenses in order to use the third
*    party software contained in the Software.
*
*    Subject to the terms of this Agreement, PayPal hereby grants you a
*    non-exclusive, worldwide, royalty free license to use, reproduce, publicly
*    display, publicly perform, distribute and sublicense the Documentation for
*    any purpose.  You may not modify the  Documentation.
*
*    No title to the intellectual property in the Software or Documentation is
*    transferred to you under the terms of this Agreement.  You do not acquire
*    any rights to the Software or the Documentation except as expressly set
*    forth in this Agreement.
*
*    If you choose to distribute the Software in a commercial product, you do
*    so with the understanding that you agree to defend, indemnify and hold
*    harmless PayPal and its suppliers against any losses, damages and costs
*    arising from the claims, lawsuits or other legal actions arising out of
*    such distribution.  You may distribute the Software in object code form
*    under your own license, provided that your license agreement:
*
*    (a)    complies with the terms and conditions of this license agreement;
*
*    (b)    effectively disclaims all warranties and conditions, express or
*           implied, on behalf of PayPal;
*
*    (c)    effectively excludes all liability for damages on behalf of PayPal;
*
*    (d)    states that any provisions that differ from this Agreement are
*           offered by you alone and not PayPal; and
*
*    (e)    states that the Software is available from you or PayPal and
*           informs licensees how to obtain it in a reasonable manner on or
*           through a medium customarily used for software exchange.
*
*    2.  DISCLAIMER OF WARRANTY
*    PAYPAL LICENSES THE SOFTWARE AND DOCUMENTATION TO YOU ONLY ON AN "AS IS"
*    BASIS WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, EITHER EXPRESS OR
*    IMPLIED, INCLUDING WITHOUT LIMITATION ANY WARRANTIES OR CONDITIONS OF
*    TITLE, NON-INFRINGEMENT, MERCHANTABILITY OR FITNESS FOR A PARTICULAR
*    PURPOSE.  PAYPAL MAKES NO WARRANTY THAT THE SOFTWARE OR DOCUMENTATION WILL
*    BE ERROR-FREE.  Each user of the Software or Documentation is solely
*    responsible for determining the appropriateness of using and distributing
*    the Software and Documentation and assumes all risks associated with its
*    exercise of rights under this Agreement, including but not limited to the
*    risks and costs of program errors, compliance with applicable laws, damage
*    to or loss of data, programs, or equipment, and unavailability or
*    interruption of operations.  Use of the Software and Documentation is made
*    with the understanding that PayPal will not provide you with any technical
*    or customer support or maintenance.  Some states or jurisdictions do not
*    allow the exclusion of implied warranties or limitations on how long an
*    implied warranty may last, so the above limitations may not apply to you.
*    To the  extent permissible, any implied warranties are limited to ninety
*    (90) days.
*
*    3.  LIMITATION OF LIABILITY
*    PAYPAL AND ITS SUPPLIERS SHALL NOT BE LIABLE FOR LOSS OR DAMAGE ARISING
*    OUT OF THIS AGREEMENT OR FROM THE USE OF THE SOFTWARE OR DOCUMENTATION.
*    IN NO EVENT WILL PAYPAL OR ITS SUPPLIERS BE LIABLE TO YOU OR ANY THIRD
*    PARTY FOR ANY DIRECT, INDIRECT, CONSEQUENTIAL, INCIDENTAL, OR SPECIAL
*    DAMAGES INCLUDING LOST PROFITS, LOST SAVINGS, COSTS, FEES, OR EXPENSES OF
*    ANY KIND ARISING OUT OF ANY PROVISION OF THIS AGREEMENT OR THE USE OR THE
*    INABILITY TO USE THE SOFTWARE OR DOCUMENTATION, HOWEVER CAUSED AND UNDER
*    ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY OR TORT
*    INCLUDING NEGLIGENCE OR OTHERWISE), EVEN IF ADVISED OF THE POSSIBILITY OF
*    SUCH DAMAGES.  PAYPAL'S AGGREGATE LIABILITY AND THAT OF ITS SUPPLIERS
*    UNDER OR IN CONNECTION WITH THIS AGREEMENT SHALL BE LIMITED TO THE AMOUNT
*    PAID BY YOU FOR THE SOFTWARE AND DOCUMENTATION.
*
*    4.  TRADEMARK USAGE
*    PayPal is a trademark PayPal, Inc. in the United States and other
*    countries. Such trademarks may not be used to endorse or promote any
*    product unless expressly permitted under separate agreement with PayPal.
*
*    5.  TERM
*    Your rights under this Agreement shall terminate if you fail to comply
*    with any of the material  terms or conditions of this Agreement and do not
*    cure such failure in a reasonable period of time after becoming aware of
*    such noncompliance.  If all your rights under this Agreement terminate,
*    you agree to cease use and distribution of the Software and Documentation
*    as soon as reasonably practicable.
*
*    6. GOVERNING LAW AND JURISDICTION. This Agreement is governed by the
*    statutes and laws of the State of California, without regard to the
*    conflicts of law principles thereof.  If any part of this Agreement is
*    found void and unenforceable, it will not affect the validity of the
*    balance of the Agreement, which shall remain valid and enforceable
*    according to its terms.  Any dispute arising out of or related to this
*    Agreement shall be brought in the courts of Santa Clara County,
*    California, USA.
*
*    7.  GENERAL
*    You acknowledge that you have read this Agreement, understand it, and
*    that it is the complete and exclusive statement of your agreement with
*    PayPal which supersedes any prior agreement, oral or written, between
*    PayPal and you with respect to the licensing to you of the Software and
*    Documentation. No variation of the terms of this Agreement will be
*    enforceable against PayPal unless PayPal gives its express consent
*    in writing signed by an authorized signatory of PayPal.
*
****************************************************************************
*
*    WARNING: Do not embed plaintext credentials in your application code.
*    Doing so is insecure and against best practices.
*    Your API credentials must be handled securely. Please consider
*    encrypting them for use in any production environment, and ensure
*    that only authorized individuals may view or modify them.
*
***************************************************************************/

/**
 * This class provides static utility functions that will be used by the WPS samples
 */
class Utils {
    /**
     * Builds the URL for the input file using the HTTP request information
     *
     * @param    string    The name of the new file
     * @return   string    The full URL for the input file
     *
     * @access   public
     * @static
     */
    function getURL($fileContextPath_) {
        $server_protocol = htmlspecialchars($_SERVER["SERVER_PROTOCOL"]);
        $server_name = htmlspecialchars($_SERVER["SERVER_NAME"]);
        $server_port = htmlspecialchars($_SERVER["SERVER_PORT"]);
        $url = strtolower(substr($server_protocol,0, strpos($server_protocol, '/'))); // http
        $url .= "://$server_name:$server_port/$fileContextPath_";

        return $url;
    } // getURL

    /**
     * Send HTTP POST Request
     *
     * @param    string    The request URL
     * @param    string    The POST Message fields in &name=value pair format
     * @param    bool      determines whether to return a parsed array (true) or a raw array (false)
     * @return    array    Contains a bool status, error_msg, error_no,
     *                     and the HTTP Response body(parsed=httpParsedResponseAr
     *                     or non-parsed=httpResponse) if successful
     *
     * @access    public
     * @static
     */
    function PPHttpPost($url_, $postFields_, $parsed_) {
        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url_);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        //turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);

        //setting the nvpreq as POST FIELD to curl
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postFields_);

        //getting response from server
        $httpResponse = curl_exec($ch);

        if(!$httpResponse) {
            return array("status" => false, "error_msg" => curl_error($ch), "error_no" => curl_errno($ch));
        }

        if(!$parsed_) {
            return array("status" => true, "httpResponse" => $httpResponse);
        }

        $httpResponseAr = explode("\n", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if(sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if(0 == sizeof($httpParsedResponseAr)) {
            $error = "Invalid HTTP Response for POST request($postFields_) to $url_.";
            return array("status" => false, "error_msg" => $error, "error_no" => 0);
        }
        return array("status" => true, "httpParsedResponseAr" => $httpParsedResponseAr);

    } // PPHttpPost

    /**
     * Redirect to Error Page
     *
     * @param    string    Error message
     * @param    int        Error number
     *
     * @access    public
     * @static
     */
    function PPError($error_msg, $error_no) {
        // create a new curl resource
        $ch = curl_init();

        // set URL and other appropriate options
        $php_self = substr(htmlspecialchars($_SERVER["PHP_SELF"]), 1); // remove the leading /
        $redirectURL = Utils::getURL(substr_replace($php_self, "Error.php", strrpos($php_self, '/') + 1));
        curl_setopt($ch, CURLOPT_URL, $redirectURL);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // set POST fields
        $postFields = "error_msg=".urlencode($error_msg)."&error_no=".urlencode($error_no);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postFields);

        // grab URL, and print
        curl_exec($ch);
        curl_close($ch);
    }
} // Utils
?>
