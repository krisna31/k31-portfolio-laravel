import{r as w,W as v,j as s}from"./app-83e90308.js";import{I as n}from"./InputError-19cba93f.js";import{I as d}from"./InputLabel-e9ae9251.js";import{P as y}from"./PrimaryButton-29cbb5ba.js";import{T as c}from"./TextInput-106ff68d.js";import{e as _}from"./transition-19ac5dd8.js";function S({className:x=""}){const p=w.useRef(),i=w.useRef(),{data:e,setData:a,errors:t,put:f,reset:o,processing:j,recentlySuccessful:h}=v({current_password:"",password:"",password_confirmation:""}),g=r=>{r.preventDefault(),f(route("password.update"),{preserveScroll:!0,onSuccess:()=>o(),onError:l=>{var m,u;l.password&&(o("password","password_confirmation"),(m=p.current)==null||m.focus()),l.current_password&&(o("current_password"),(u=i.current)==null||u.focus())}})};return s.jsxs("section",{className:x,children:[s.jsxs("header",{children:[s.jsx("h2",{className:"text-lg font-medium text-gray-900 dark:text-gray-100",children:"Update Password"}),s.jsx("p",{className:"mt-1 text-sm text-gray-600 dark:text-gray-400",children:"Ensure your account is using a long, random password to stay secure."})]}),s.jsxs("form",{onSubmit:g,className:"mt-6 space-y-6",children:[s.jsxs("div",{children:[s.jsx(d,{htmlFor:"current_password",value:"Current Password"}),s.jsx(c,{id:"current_password",ref:i,value:e.current_password,onChange:r=>a("current_password",r.target.value),type:"password",className:"mt-1 block w-full",autoComplete:"current-password"}),s.jsx(n,{message:t.current_password,className:"mt-2"})]}),s.jsxs("div",{children:[s.jsx(d,{htmlFor:"password",value:"New Password"}),s.jsx(c,{id:"password",ref:p,value:e.password,onChange:r=>a("password",r.target.value),type:"password",className:"mt-1 block w-full",autoComplete:"new-password"}),s.jsx(n,{message:t.password,className:"mt-2"})]}),s.jsxs("div",{children:[s.jsx(d,{htmlFor:"password_confirmation",value:"Confirm Password"}),s.jsx(c,{id:"password_confirmation",value:e.password_confirmation,onChange:r=>a("password_confirmation",r.target.value),type:"password",className:"mt-1 block w-full",autoComplete:"new-password"}),s.jsx(n,{message:t.password_confirmation,className:"mt-2"})]}),s.jsxs("div",{className:"flex items-center gap-4",children:[s.jsx(y,{disabled:j,children:"Save"}),s.jsx(_,{show:h,enter:"transition ease-in-out",enterFrom:"opacity-0",leave:"transition ease-in-out",leaveTo:"opacity-0",children:s.jsx("p",{className:"text-sm text-gray-600 dark:text-gray-400",children:"Saved."})})]})]})]})}export{S as default};