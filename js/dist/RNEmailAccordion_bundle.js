rndefine("#RNEmailAccordion",["#RNEmailCore/LitElementBase","lit/decorators","lit","#RNEmailLit/Lit"],(function(t,e,i,n){"use strict";var o,s,r,c,l,a={};!function(t){Object.defineProperty(t,"__esModule",{value:!0});var e="chevron-down",i=[],n="f078",o="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z";t.definition={prefix:"fas",iconName:e,icon:[448,512,i,n,o]},t.faChevronDown=t.definition,t.prefix="fas",t.iconName=e,t.width=448,t.height=512,t.ligatures=i,t.unicode=n,t.svgPathData=o}(a);let h=(o=e.customElement("rn-accordion-item"),s=e.query(".rnAccordionContent"),o((c=class extends t.LitElementBase{constructor(...t){super(...t),this.isOpen=!0,this.previousIsOpen=null,babelHelpers.initializerDefineProperty(this,"AccordionContent",l,this)}static get properties(){return{label:{type:String},titleStyles:{type:Object},contentStyles:{type:Object},title:{type:String},rightSide:{type:Object},content:{type:Object},isOpen:{type:Boolean}}}async performUpdate(){null!==this.previousIsOpen&&this.previousIsOpen!=this.isOpen?(this.isOpen,this.isOpen?this.ExecuteOpenAnimation():this.ExecuteCloseAnimation(),this.previousIsOpen=this.isOpen):(this.previousIsOpen=this.isOpen,super.performUpdate())}ExecuteOpenAnimation(){this.AllUpdateComplete.then((async()=>{{let t=this.AccordionContent.getBoundingClientRect().height+"px";this.AccordionContent.style.height="0",this.AccordionContent.style.position="static",this.AccordionContent.style.opacity="1";let e=()=>{this.AccordionContent.removeEventListener("transitionend",e),this.AccordionContent.style.height="auto",super.performUpdate()};this.AccordionContent.addEventListener("transitionend",e),requestAnimationFrame((()=>{this.AccordionContent.style.height=t,this.renderRoot.querySelector(".chevron").style.transform="rotate(-0deg)"}))}})),super.performUpdate(),this.AccordionContent.style.position="absolute",this.AccordionContent.style.opacity="0"}ExecuteCloseAnimation(){let t,e;t=this.AccordionContent.getBoundingClientRect().height+"px",e=0,this.AccordionContent.style.height=t;let i=()=>{this.AccordionContent.removeEventListener("transitionend",i),this.AccordionContent.style.height="auto",super.performUpdate()};this.AccordionContent.addEventListener("transitionend",i),requestAnimationFrame((()=>{this.AccordionContent.style.height=0,this.renderRoot.querySelector(".chevron").style.transform="rotate(-90deg)"}))}render(){return i.html` <div> <div class="rnAccordionItem ${this.isOpen?"rnIsOpen":"rnIsClosed"}" style="display: flex;align-items: center;position: relative;${i.rnsg(this.titleStyles)}" @click=${t=>{t.preventDefault(),this.ToggleOpen()}}> <a style="display:flex;align-items:center;margin-left: 5px;font-weight: bold;" href="#"> <rn-fontawesome class="chevron" style="transform: rotate(${this.isOpen?"0":"-90"}deg)" .icon=${a.faChevronDown}> </rn-fontawesome> <div style="margin-left: 3px;display: inline;"> ${this.title} </div> </a> ${n.rnIf(this.rightSide&&i.html` <div style="position: absolute;right: 5px;"> ${this.rightSide} </div> `)} </div> ${n.rnIf(this.isOpen&&i.html`<div class="rnAccordionContent" style="box-sizing: content-box;border: 1px solid #dfdfdf;${i.rnsg(this.contentStyles)}"> ${this.content} </div>`)} </div> `}ToggleOpen(){this.FireEvent("isOpenChanged",!this.isOpen)}},l=babelHelpers.applyDecoratedDescriptor(c.prototype,"AccordionContent",[s],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),r=c))||r);exports.AccordionItem=h}));
