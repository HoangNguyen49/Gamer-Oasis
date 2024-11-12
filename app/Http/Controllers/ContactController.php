<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // Phương thức hiển thị form
    public function showForm()
    {
        return view('web.pages.contact');
    }

    // Phương thức xử lý gửi form
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'customerName' => 'required|string|max:255',
            'customerEmail' => 'required|email|max:255',
            'contactSubject' => 'nullable|string|max:255',
            'contactMessage' => 'nullable|string',
        ]);

        // Lưu thông tin vào cơ sở dữ liệu
        Contact::create([
            'customer_name' => $validated['customerName'],
            'customer_email' => $validated['customerEmail'],
            'contact_subject' => $validated['contactSubject'] ?? '',
            'contact_message' => $validated['contactMessage'] ?? '',
            'status' => 'pending', // Mặc định trạng thái là 'pending'
        ]);

        // Trả về thông báo thành công
        return back()->with('success', 'Thank you for contacting us!');
    }

    // Phương thức hiển thị danh sách liên hệ
    public function index(Request $request)
    {
        // Lấy từ query string (nếu có)
        $search = $request->input('search');

        // Nếu có từ khóa tìm kiếm, lọc theo Customer Name hoặc Contact Subject
        if ($search) {
            $contacts = Contact::where('customer_name', 'like', '%' . $search . '%')
                ->orWhere('contact_subject', 'like', '%' . $search . '%')
                ->paginate(10);
        } else {
            // Nếu không tìm kiếm, hiển thị tất cả dữ liệu
            $contacts = Contact::paginate(10);
        }

        // Trả dữ liệu vào view
        return view('admin.pages.contacts', compact('contacts'));
    }

    // Phương thức hiển thị thông tin chi tiết của liên hệ
    public function showDetail($id)
    {
        // Lấy thông tin chi tiết của liên hệ theo ID
        $contact = Contact::findOrFail($id);

        // Trả thông tin chi tiết vào view
        return view('admin.pages.contact_detail', compact('contact'));
    }

    // Phương thức cập nhật trạng thái của liên hệ
    public function updateStatus($id)
    {
        $contact = Contact::find($id);

        // Đổi trạng thái giữa 'pending' và 'processed'
        $contact->status = $contact->status === 'pending' ? 'processed' : 'pending';
        $contact->save();

        return back()->with('success', 'Status updated successfully.');
    }
}
