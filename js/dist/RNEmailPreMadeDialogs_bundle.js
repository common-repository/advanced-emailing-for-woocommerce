rndefine("#RNEmailPreMadeDialogs",["#RNEmailDialog/DialogBase","lit/decorators","#RNEmailDialog/Dialog","lit"],(function(t,l,e,n){"use strict";var o;let i=l.customElement("rn-pm-delete-dialog")(o=class extends t.DialogBase{InternalGetOptions(){return{Title:this.title,ShowApplyButton:!0,ApplyButtonTitle:"Yes",CloseButtonTitle:"No"}}SubRender(){return n.html` ${this.content} `}static async Show(t="Do you want to continue?",l=null,o=null){return await e.Dialog.Show(n.html`<rn-pm-delete-dialog .title="${t}" .content="${l}" .applyCallBack="${o}"></rn-pm-delete-dialog>`)}async OnApply(){let t=!0;return null!=this.applyCallBack&&(t=await this.applyCallBack()),t&&this.SendResult(t),t}})||o;var a;let r=l.customElement("rn-pm-confirm-dialog")(a=class extends t.DialogBase{InternalGetOptions(){return{Title:this.title,ShowApplyButton:!0,ApplyButtonTitle:"Yes",CloseButtonTitle:"No"}}SubRender(){return n.html` ${this.content} `}static async Show(t="Do you want to continue?",l=null){return await e.Dialog.Show(n.html`<rn-pm-confirm-dialog .title="${t}" .content="${l}"></rn-pm-confirm-dialog>`)}async OnApply(){return this.SendResult(!0),!0}})||a;exports.DeleteDialog=i,exports.ConfirmDialog=r}));
