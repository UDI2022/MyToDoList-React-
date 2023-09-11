import React from 'react';
import { useForm } from '@inertiajs/react';
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";

/**
 * data:状態を保管。
 *      初期値は useForm({title: ''})のように与えることができる。
 * setData:dataを変更するための関数。非同期
 * post:postする関数。他にget,put,patch,deleteがある。
 * processing: フォームの処理が始まるとtrueに変わる。
 *              フォームの処理中に送信ボタンを無効にして、複数回の送信を防ぐのに使用できる。
 * reset:dataを初期値に戻す。一部を戻す操作も可能。
 * errors:Controller側でバリデーションエラーが出た場合、フィールドとエラーメッセージがerrorsに返ってくる
 *         ->InputErrorコンポーネントに渡してエラーの場合のみ、メッセージを赤字表示する。
 * ・参照:https://inertiajs.com/forms
 * 
 * ▼動作
 * Submitボタンを押すとroute('todo.store')宛にdataがpostされる。
 * pstが成功したらdataを消去し、それに合わせてフォームの値value={data.title}が更新されてinput内の表示が削除。
 */
export default function SubmitTodo() {
    const {data, setData, post, processing, reset, errors} = useForm({
        title: '',
    });

    
    const submit = (e) => {
        e.preventDefault();
        post(route('todo.store'), {onSuccess: () => reset()});
    };

    return (
        <form onSubmit={submit}>
            <input 
                value={data.title}
                placeholder="new todo"
                className="w-7/12 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 ruonded-md shadow-sm"
                onChange={e => setData('title', e.target.value)}
            ></input>
            <InputError message={errors.message} className="mt-2" />
            <PrimaryButton className="ml-3 mt-4" disabled={processing}>submit</PrimaryButton>
        </form>
    );
}