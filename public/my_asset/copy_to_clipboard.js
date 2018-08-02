/*!
 *  copy_to_clipboard.js
 *
 *  <textarea id="title">example</textarea>
 *
 *  HOW TO USE:
 *  <button type="button" onclick="copyToClipboard('title')">Copy</button>
 *
 */
function copyToClipboard(element) {
  var copyText = document.getElementById(element);
  copyText.select();
  document.execCommand("Copy");
}
