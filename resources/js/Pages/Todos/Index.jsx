import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react'

/**
 * ページタイトル:Todo(動的に変更可能)
 * className
 *  max-w-2xl:最大幅を2xlに設定
 *  mx-auto:左右のmarginをautoに設定
 *  p-4:全方向のpaddingを4に設定
 *  sm:p-6: 画面サイズがsmallサイズの時、全方向のpaddingを6に設定
 *  lg:p-8:画面サイズがlargeサイズの時、全方向のpaddingを8に設定
 */
export default function Index({ auth }) {
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Todo" />

            <div className="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                Hello, This is Todos/Index cmponent.
            </div>
        </AuthenticatedLayout>
    );
}