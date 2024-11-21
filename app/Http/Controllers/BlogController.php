<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\BlogImg;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /* Phương thức xử lý index cho trang admin blog */
    public function index(Request $request)
    {
        // 1. Lấy top 5 bài viết có lượt đánh giá cao nhất bằng phương thức trong model
        $topBlogs = Blog::with('comments')
            ->get()
            ->sortByDesc(function ($blog) {
                return $blog->totalRatingScore();
            })
            ->take(5);

        // 2. Lấy giá trị tìm kiếm từ request
        $search = $request->input('search');

        // 3. Thực hiện tìm kiếm và phân trang cho bảng dưới
        $blogs = Blog::when($search, function ($query, $search) {
            return $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('id', $search);
        })
            ->paginate(10); // Hiển thị 10 bài viết mỗi trang

        // Trả về view với dữ liệu topBlogs, blogs và giá trị tìm kiếm hiện tại
        return view('admin.pages.quanliblog', compact('topBlogs', 'blogs', 'search'));
    }

    /* Phương thức xử lý index cho trang admin tạo blog */
    public function create()
    {
        return view('admin.pages.form-add-blog');
    }

    /* Phương thức xử lý việc tạo 1 blog trong trang admin */
    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title',
            'description' => 'required|string',
        ]);

        // Generate slug
        $slug = $this->generateSlug($request->title);

        // Save blog
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->slug = $slug;
        $blog->save();

        // Handle images from description
        $this->handleImagesFromDescription($request->description, $blog->id);

        // Retrieve updated topBlogs and all blogs
        $topBlogs = Blog::with('comments')
            ->get()
            ->sortByDesc(function ($blog) {
                return $blog->totalRatingScore();
            })
            ->take(5);
        $blogs = Blog::paginate(10); // Adjust pagination as per your requirements

        // Return view with topBlogs and blogs
        return redirect()->route('index')->with('success', 'The blog has been added successfully!');
    }

    /* Phương thức img từ desciption -> bảng blog_imgs ( lưu vào ) -> web ( giao diện người dùng ) */
    public function handleImagesFromDescription($description, $blogId)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach ($dom->getElementsByTagName('img') as $img) {
            // Lấy giá trị thuộc tính src mà không sử dụng getAttribute
            $src = '';
            foreach ($img->attributes as $attr) {
                if ($attr->name === 'src') {
                    $src = $attr->value; // Lấy giá trị của thuộc tính src
                    break; // Thoát khỏi vòng lặp sau khi tìm thấy
                }
            }

            // Tải hình ảnh từ URL
            if (!empty($src)) {
                $imageData = file_get_contents($src);
                if ($imageData) {
                    // Tạo tên file duy nhất
                    $imageName = uniqid('blog_') . '.jpg';

                    // Lưu hình ảnh vào thư mục public/asset/images/blog
                    $imagePath = $this->saveImageToPublic($imageData, $imageName);

                    // Lưu thông tin vào bảng blog_imgs
                    $blogImg = new BlogImg();
                    $blogImg->blog_id = $blogId;
                    $blogImg->img = $imagePath; // Lưu vào cột img
                    $blogImg->save();
                }
            }
        }
    }

/* Phương thức tạo đường dẫn lưu hình ảnh đến asset/images/blog */
    public function saveImageToPublic($imageData, $imageName)
    {
        // Đường dẫn đến thư mục lưu ảnh
        $destinationPath = public_path('asset/images/blog');

        // Kiểm tra nếu thư mục chưa tồn tại, tạo thư mục
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true); // Tạo thư mục với quyền truy cập
        }

        // Tạo đường dẫn đầy đủ để lưu ảnh
        $imagePath = $destinationPath . '/' . $imageName;

        // Lưu hình ảnh vào thư mục public
        file_put_contents($imagePath, $imageData);

        return 'asset/images/blog/' . $imageName; // Trả về đường dẫn tương đối để lưu vào DB
    }

    /* Phương thức tạo slug */
    private function generateSlug($title)
    {
        // Chuyển thành chữ thường
        $slug = strtolower($title);
        // Thay thế các ký tự không phải chữ số và chữ cái bằng dấu gạch nối
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        // Xóa dấu gạch nối ở đầu và cuối
        $slug = trim($slug, '-');

        // Kiểm tra slug có tồn tại trong cơ sở dữ liệu không
        $originalSlug = $slug; // Lưu slug gốc
        $count = 1;

        // Nếu slug đã tồn tại, thêm số vào sau slug
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /* Phương thức xử lý 1 HTML từ description */
    private function processDescription($description)
    {
        // Đảm bảo chuỗi được mã hóa UTF-8
        $description = mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8');

        $dom = new \DOMDocument();
        @$dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Xử lý hình ảnh
        foreach ($dom->getElementsByTagName('img') as $img) {
            
        }

        // Xử lý video
        foreach ($dom->getElementsByTagName('iframe') as $video) {
            // Xử lý video ở đây
        }

        // Trả về HTML đã được xử lý và đảm bảo mã hóa UTF-8
        return mb_convert_encoding($dom->saveHTML(), 'UTF-8', 'HTML-ENTITIES');
    }

    /*Phương thức xử lý việc đổ dữ liệu ra trang web pages */
    public function show($slug)
    {
        // Tìm blog theo slug
        $blog = Blog::where('slug', $slug)->firstOrFail();

        // Lấy ảnh đầu tiên từ bảng blog_imgs
        $firstImage = BlogImg::where('blog_id', $blog->id)->first();

        // Lấy Top 5 blogs có lượt đánh giá cao
        $topBlogs = Blog::with('comments')
            ->get()
            ->sortByDesc(function ($blog) {
                return $blog->totalRatingScore();
            })
            ->take(5);

        // Trả về view với dữ liệu blog, ảnh đầu tiên và top 5 blogs
        return view('web.pages.blog-detail', compact('blog', 'firstImage', 'topBlogs'));
    }

    /* Phương thức chỉnh sửa 1 blog trong trang admin */
    public function edit($id)
    {
        // Tìm blog theo ID
        $blog = Blog::findOrFail($id);

        // Trả về view chỉnh sửa với dữ liệu blog
        return view('admin.pages.form-edit-blog', compact('blog'));
    }

    /* Phương thức cập nhật 1 blog trong trang admin */
    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Tìm blog theo ID
        $blog = Blog::findOrFail($id);

        // Xóa hình ảnh cũ trong cơ sở dữ liệu và trong thư mục lưu trữ
        $existingImages = BlogImg::where('blog_id', $blog->id)->get();
        foreach ($existingImages as $image) {
            $imagePath = public_path($image->img);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Xóa hình ảnh từ thư mục
            }
            $image->delete(); // Xóa bản ghi hình ảnh khỏi database
        }

        // Cập nhật các trường của blog
        $blog->title = $request->title;
        $blog->slug = $this->generateSlug($request->title);
        $blog->description = $this->processDescription($request->description);

        // Xử lý và lưu hình ảnh từ mô tả
        $this->handleImagesFromDescription($request->description, $blog->id);

        // Lưu thay đổi vào database
        $blog->save();

        // Chuyển hướng về trang quanliblog sau khi cập nhật
        return redirect()->route('index')->with('success', 'The blog has been successfully updated!');
    }
    /* Phương thức cho việc xóa 1 blog trong trang admin */
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if ($blog) {
            // Delete associated images
            $blogImages = BlogImg::where('blog_id', $blog->id)->get();
            foreach ($blogImages as $image) {
                $imagePath = public_path($image->img);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete();
            }

            // Delete blog
            $blog->delete();

            // Return success response as JSON
            return response()->json(['success' => 'You have successfully deleted the blog!']);
        }

        // Return error response if blog not found
        return response()->json(['error' => 'The blog does not exist.'], 404);
    }

    //Phương thức lưu cmt
    public function storeComment(Request $request, $slug)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        // Tìm blog theo slug
        $blog = Blog::where('slug', $slug)->firstOrFail();

        // Lưu bình luận
        BlogComment::create([
            'blog_id' => $blog->id,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Chuyển hướng về trang chi tiết blog với thông báo thành công
        return redirect()->route('show', ['slug' => $slug])->with('success', 'The comment has been added successfully!');
    }
//Phương thức xem bình luận 1 bài blog
    public function viewComments($id)
    {
        // Lấy blog theo ID
        $blog = Blog::findOrFail($id);

        // Lấy tất cả bình luận liên quan đến blog này, bao gồm cả phản hồi
        $comments = $blog->comments()->with('replies')->get(); // Lấy bình luận và phản hồi

        return view('admin.pages.form-view-cmt', compact('blog', 'comments'));
    }

//Phương thức xóa bình luận 1 bài blog
    public function deleteComment($id)
    {
        // Tìm bình luận theo ID
        $comment = BlogComment::find($id);

        if ($comment) {
            // Xóa bình luận
            $comment->delete();

            // Trả về phản hồi thành công
            return response()->json(['success' => 'The comment has been deleted successfully!']);
        }

        // Trả về phản hồi lỗi nếu không tìm thấy bình luận
        return response()->json(['error' => 'The comment does not exist.'], 404);
    }

    //Sắp xếp các bài viết có lượt đánh giá cao
    public function topRatedBlogs()
    {
        // Lấy tất cả các bài viết cùng tổng điểm đánh giá, sắp xếp theo điểm đánh giá cao nhất
        $blogs = Blog::with('comments')->get()->sortByDesc(function ($blog) {
            return $blog->totalRatingScore();
        });

        return view('admin.pages.top_rated_blogs', compact('blogs'));
    }

    public function reply(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'comment' => 'required|string',
            'parent_id' => 'required|exists:blog_comments,id',
        ]);

        BlogComment::create([
            'blog_id' => BlogComment::findOrFail($request->parent_id)->blog_id,
            'user_name' => $request->input('user_name'),
            'user_email' => $request->input('user_email'),
            'comment' => $request->input('comment'),
            'parent_id' => $request->input('parent_id'),
            'rating' => 0,
        ]);

        return redirect()->back()->with('success', 'Your response has been submitted!');
    }

}
