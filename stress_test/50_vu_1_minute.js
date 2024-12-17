import http from "k6/http";
import { sleep } from "k6";
import { htmlReport } from "./html_report_bundle.js";

export const options = {
    vus: 50,
    duration: "1m",
};

export default function () {
    http.get('https://yoklah.absen.k31.my.id/');
    sleep(1);
}

export function handleSummary(data) {
    return {
        "summary_50_vu_1_minute.html": htmlReport(data),
    };
}
