(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-597a36f4"],{"050f":function(t,e,n){"use strict";n("0b39")},"0b39":function(t,e,n){},"190e":function(t,e,n){"use strict";n("9e19")},"377a":function(t,e,n){t.exports=n.p+"assets/img/heig_2020.a17b492d.svg"},"9e19":function(t,e,n){},f82c:function(t,e,n){"use strict";n.r(e);var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("app-layout",[n("router-view")],1)},c=[],a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{class:t.getMenuType,attrs:{id:"app-container"}},[n("topnav"),t._v(" "),n("sidebar"),t._v(" "),n("main",[n("div",{staticClass:"container-fluid"},[t._t("default")],2)])],1)},i=[],o=n("5530"),l=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"sidebar",on:{click:function(t){return t.stopPropagation(),function(){}.apply(null,arguments)}}},[n("div",{staticClass:"main-menu",style:{background:"whitesmoke"}},[n("vue-perfect-scrollbar",{staticClass:"scroll",style:{"touch-action":"none"},attrs:{settings:{suppressScrollX:!0,wheelPropagation:!1}}},[n("ul",{staticClass:"list-unstyled"},t._l(t.filteredMenuItems,(function(e,s){return n("li",{key:s,style:{"margin-left":"-30%"},attrs:{"data-flag":e.id},on:{click:function(n){return t.executeFunction(e.action)}}},[n("router-link",{attrs:{to:e.to}},[n("v-icon",[t._v(t._s(e.icon))]),t._v(" "),n("span",{staticClass:"menu-text"},[t._v("\n              "+t._s(e.label)+"\n            ")])],1)],1)})),0)])],1)])},r=[],u=(n("4de4"),n("d3b7"),n("2f62")),b=n("2b47"),d=n("94ed"),m=[{id:"new-job",icon:d["b"],label:"Nouvelle demande",to:"",clientAccess:!0,technicianAccess:!1,action:function(t){t.openJobForm(null)}},{id:"job-list",icon:d["h"],label:"Travaux réalisables",to:"".concat(b["a"],"/job-list"),clientAccess:!0,technicianAccess:!0,action:function(t){}},{id:"my-jobs",icon:d["e"],label:"Mes commandes",to:"".concat(b["a"],"/my-jobs"),clientAccess:!0,technicianAccess:!0,action:function(t){}},{id:"all-jobs",icon:d["d"],label:"Commandes clients",to:"".concat(b["a"],"/all-jobs"),clientAccess:!1,technicianAccess:!0,action:function(t){}},{id:"settings",icon:d["a"],label:"Paramètres",to:"".concat(b["a"],"/settings"),clientAccess:!0,technicianAccess:!0,action:function(t){}}],f=m,v={data:function(){return{menuItems:f}},methods:Object(o["a"])(Object(o["a"])({},Object(u["b"])(["openJobForm"])),{},{executeFunction:function(t){t(this)}}),computed:Object(o["a"])(Object(o["a"])({},Object(u["c"])({user:"getUser"})),{},{filteredMenuItems:function(){var t=this;return this.menuItems.filter((function(e){return e.clientAccess&&!t.user.is_technician||e.technicianAccess&&t.user.is_technician}))}})},p=v,_=(n("190e"),n("2877")),h=Object(_["a"])(p,l,r,!1,null,"73be4135",null),g=h.exports,C=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("nav",{staticClass:"navbar fixed-top"},[s("v-row",[s("v-col",{style:{display:"flex"}},[s("v-btn",{style:{"margin-left":"1.5rem"},attrs:{icon:"",ripple:!1},on:{click:function(e){return t.changeSideMenuStatus({step:t.menuClickCount+1,classNames:t.menuType,selectedMenuHasSubItems:t.selectedMenuHasSubItems})}}},[s("v-icon",[t._v(t._s(t.mdiMenu))])],1),t._v(" "),s("v-btn",{style:{"margin-left":"30px"},attrs:{ripple:!1,icon:""}},[s("router-link",{attrs:{to:t.adminRoot+"/my-jobs"}},[s("v-img",{attrs:{src:n("377a"),contain:"","max-width":"50px"}})],1)],1)],1),t._v(" "),s("v-col",{style:{"text-align":"center"}},[s("h4",[s("strong",[t._v(" Gestionnaire des travaux du FabLab ")])])]),t._v(" "),s("v-col",[s("div",{staticClass:"div-style"},[s("router-link",{attrs:{to:t.adminRoot+"/my-jobs"}},[s("v-badge",{attrs:{content:t.notifications,value:t.notifications>0,color:"blue",overlap:""}},[s("v-icon",[t._v("mdi-bell")])],1)],1),t._v(" "),s("v-menu",{attrs:{"offset-y":""},scopedSlots:t._u([{key:"activator",fn:function(e){var n=e.on,c=e.attrs;return[s("v-btn",t._g(t._b({staticClass:"btn-noUpper",attrs:{color:"dark",text:"",ripple:!1,"max-width":"100%"}},"v-btn",c,!1),n),[s("span",{ref:"span",staticClass:"name-style"},[t._v(t._s(t.user.name))])])]}}])},[t._v(" "),s("v-list",[s("v-list-item",{on:{click:t.clickLogout}},[t._v(" Se déconnecter ")])],1)],1)],1)])],1)],1)},j=[],y={data:function(){return{adminRoot:b["a"],mdiMenu:d["g"]}},methods:Object(o["a"])(Object(o["a"])(Object(o["a"])({},Object(u["d"])(["changeSideMenuStatus"])),Object(u["b"])(["logout"])),{},{clickLogout:function(){var t=this;this.logout().then((function(){t.$router.go()}))}}),computed:Object(o["a"])({},Object(u["c"])({menuType:"getMenuType",menuClickCount:"getMenuClickCount",selectedMenuHasSubItems:"getSelectedMenuHasSubItems",notifications:"getNotifications",user:"getUser"})),mounted:function(){this.$refs.span.parentElement.style.width="100%"}},k=y,x=(n("050f"),Object(_["a"])(k,C,j,!1,null,"7e9a8932",null)),O=x.exports,w=function(){var t=this,e=t.$createElement;t._self._c;return t._m(0)},M=[function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("footer",{staticClass:"page-footer"},[n("div",{staticClass:"footer-content"},[n("div",{staticClass:"container-fluid"},[n("div",{staticClass:"row"},[n("div",{staticClass:"col-12 col-sm-6"},[n("p",{staticClass:"mb-0 text-muted"},[t._v("ColoredStrategies 2019")])]),t._v(" "),n("div",{staticClass:"col-sm-6 d-none d-sm-block"},[n("ul",{staticClass:"breadcrumb pt-0 pr-0 float-right"},[n("li",{staticClass:"breadcrumb-item mb-0"},[n("a",{staticClass:"btn-link",attrs:{href:"#"}},[t._v("Review")])]),t._v(" "),n("li",{staticClass:"breadcrumb-item mb-0"},[n("a",{staticClass:"btn-link",attrs:{href:"#"}},[t._v("Purchase")])]),t._v(" "),n("li",{staticClass:"breadcrumb-item mb-0"},[n("a",{staticClass:"btn-link",attrs:{href:"#"}},[t._v("Docs")])])])])])])])])}],S={},A=S,I=Object(_["a"])(A,w,M,!1,null,null,null),$=I.exports,E={components:{topnav:O,sidebar:g,"footer-component":$},data:function(){return{show:!1}},computed:Object(o["a"])({},Object(u["c"])(["getMenuType"])),mounted:function(){setTimeout((function(){document.body.classList.add("default-transition")}),100)}},T=E,F=Object(_["a"])(T,a,i,!1,null,"4cc4a3b8",null),H=F.exports,J={components:{"app-layout":H}},L=J,P=Object(_["a"])(L,s,c,!1,null,null,null);e["default"]=P.exports}}]);