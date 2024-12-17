import http from 'k6/http';
import { sleep } from 'k6';
import { htmlReport } from "./html_report_bundle.js";

export const options = {
    stages: [
        { duration: '2m', target: 200 },
        { duration: '1m', target: 10 },
        { duration: '2m', target: 150 },
        { duration: '4m', target: 320 },
        { duration: '30s', target: 180 },
        { duration: '30s', target: 0 },
    ],
};

export default () => {
    const urlRes = http.get('https://yoklah.absen.k31.my.id/');
    sleep(1);
};

export function handleSummary(data) {
    return {
        "summary_0_untill_200_vu_1_minute.html": htmlReport(data),
    };
}
